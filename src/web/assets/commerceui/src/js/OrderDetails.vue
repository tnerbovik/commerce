<template>
    <div v-if="draft">
        <div class="order-details" :class="{'order-opacity-50': recalculateLoading || saveLoading}">
            <template v-if="!draft">
                <div class="spinner"></div>
            </template>
            <template v-else>
                <template v-if="lineItems.length > 0">
                    <line-items
                            :line-items="lineItems"
                            :editing="editing"
                            :recalculation-mode="recalculationMode"
                            @updateLineItems="updateLineItems"
                    ></line-items>

                    <template v-if="orderAdjustments.length > 0 || editing">
                        <order-adjustments
                                :adjustments="orderAdjustments"
                                :editing="editing"
                                :recalculation-mode="recalculationMode"
                                @updateOrderAdjustments="updateOrderAdjustments"
                        ></order-adjustments>

                        <hr />
                    </template>

                    <total :order="draft.order"></total>
                </template>

                <template v-if="editing">
                    <template v-if="lineItems.length > 0">
                        <hr>
                    </template>

                    <add-line-item @addLineItem="addLineItem"></add-line-item>

                    <template v-if="lineItems.length > 0">
                        <div class="recalculate-action" v-if="editing && originalDraft.order.isCompleted">
                            <btn-link class="recalculate-btn error" @click="autoRecalculate()">{{"Recalculate order"|t('commerce')}}</btn-link>
                        </div>

                        <div v-if="recalculateLoading" class="spinner"></div>
                    </template>
                </template>
            </template>

            <template v-if="draft.order.errors">
                <pre>{{draft.order.errors}}</pre>
            </template>
        </div>
    </div>
</template>

<style lang="scss">
    @import '../sass/app';

    .recalculate-action {
        margin-top: 14px;

        .recalculate-btn {
            display: inline-block;
        }
    }
</style>

<script>
    import {mapState, mapActions} from 'vuex'
    import LineItems from './components/details/LineItems'
    import AddLineItem from './components/details/AddLineItem'
    import OrderAdjustments from './components/details/OrderAdjustments'
    import Total from './components/details/Total'

    export default {
        name: 'order-details-app',

        components: {
            AddLineItem,
            LineItems,
            OrderAdjustments,
            Total,
        },

        computed: {
            ...mapState({
                recalculateLoading: state => state.recalculateLoading,
                saveLoading: state => state.saveLoading,
                editing: state => state.editing,
                originalDraft: state => state.originalDraft
            }),

            recalculationMode() {
              return this.draft.order.recalculationMode
            },

            lineItems: {
                get() {
                    return this.draft.order.lineItems
                },

                set(lineItems) {
                    const draft = this.draft
                    draft.order.lineItems = lineItems
                    this.$store.commit('updateDraft', draft)
                    this.recalculate()
                }
            },

            orderAdjustments: {
                get() {
                    return this.draft.order.orderAdjustments
                },

                set(adjustments) {
                    const draft = this.draft
                    draft.order.orderAdjustments = adjustments
                    this.$store.commit('updateDraft', draft)
                    this.recalculate()
                }
            },

            draft: {
                get() {
                    return JSON.parse(JSON.stringify(this.$store.state.draft))
                },

                set(draft) {
                    this.$store.commit('updateDraft', draft)
                }
            },
        },

        methods: {
            ...mapActions([
                'recalculateOrder',
            ]),

            addLineItem(lineItem) {
                const lineItems = this.lineItems
                lineItems.push(lineItem)
                this.updateLineItems(lineItems)
                    .then(() => {
                        this.$store.commit('updateLastPurchasableId', lineItem.purchasableId)

                        setTimeout(function() {
                            this.$store.commit('updateLastPurchasableId', null)
                        }.bind(this), 4000)
                    })
            },

            updateLineItems(lineItems) {
                const draft = JSON.parse(JSON.stringify(this.$store.state.draft))
                draft.order.lineItems = lineItems
                return this.recalculate(draft)
            },

            updateOrderAdjustments(orderAdjustments) {
                const draft = JSON.parse(JSON.stringify(this.$store.state.draft))
                draft.order.orderAdjustments = orderAdjustments
                this.recalculate(draft)
            },

            recalculate(draft) {
                return this.recalculateOrder(draft)
                    .then(() => {
                        this.$store.dispatch('displayNotice', "Order recalculated.")
                    })
                    .catch((error) => {
                        this.$store.dispatch('displayError', error);
                    })
            },

            autoRecalculate() {
                const message = "Do you really want to auto recalculate? This will reset all manual changes to the order."

                if (window.confirm(message)) {
                    this.$store.dispatch('autoRecalculate')
                        .then(() => {
                            this.$store.dispatch('displayNotice', "Order recalculated.")
                        })
                        .catch((error) => {
                            this.$store.dispatch('displayError', error);
                        })
                }
            }
        },
    }
</script>