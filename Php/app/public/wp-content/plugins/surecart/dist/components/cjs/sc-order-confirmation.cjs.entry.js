'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-aaab7645.js');
const universe = require('./universe-0cf1168a.js');
const removeQueryArgs = require('./remove-query-args-b57e8cd3.js');
const addQueryArgs = require('./add-query-args-49dcb630.js');

const scOrderConfirmationCss = ":host{display:block;max-width:800px;margin:auto}::slotted(*:not(:last-child)),sc-form form>*:not(:last-child){margin-bottom:var(--sc-form-row-spacing-large)}.order-confirmation__content{color:var(--sc-order-confirmation-color, var(--sc-color-gray-500))}.order-confirmation__content.hidden{display:none}::part(line-items){display:grid;gap:0.5em}";
const ScOrderConfirmationStyle0 = scOrderConfirmationCss;

const ScOrderConfirmation = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.order = undefined;
        this.loading = false;
        this.error = undefined;
    }
    componentWillLoad() {
        // @ts-ignore
        universe.Universe.create(this, this.state());
        // get teh session
        this.getSession();
    }
    /** Get session id from url. */
    getSessionId() {
        var _a;
        if ((_a = this.order) === null || _a === void 0 ? void 0 : _a.id)
            return this.order.id;
        return removeQueryArgs.getQueryArg(window.location.href, 'sc_order');
    }
    /** Update a session */
    async getSession() {
        var _a;
        if (!this.getSessionId())
            return;
        if ((_a = this.order) === null || _a === void 0 ? void 0 : _a.id)
            return;
        try {
            this.loading = true;
            this.order = (await await fetch.apiFetch({
                path: addQueryArgs.addQueryArgs(`surecart/v1/checkouts/${this.getSessionId()}`, {
                    expand: [
                        'line_items',
                        'line_item.price',
                        'line_item.fees',
                        'price.product',
                        'customer',
                        'customer.shipping_address',
                        'payment_intent',
                        'discount',
                        'manual_payment_method',
                        'discount.promotion',
                        'billing_address',
                        'shipping_address',
                    ],
                    refresh_status: true,
                }),
            }));
        }
        catch (e) {
            if (e === null || e === void 0 ? void 0 : e.message) {
                this.error = e.message;
            }
            else {
                this.error = wp.i18n.__('Something went wrong', 'surecart');
            }
        }
        finally {
            this.loading = false;
        }
    }
    state() {
        var _a, _b;
        const manualPaymentMethod = (_a = this.order) === null || _a === void 0 ? void 0 : _a.manual_payment_method;
        return {
            processor: 'stripe',
            loading: this.loading,
            orderId: this.getSessionId(),
            order: this.order,
            customer: (_b = this.order) === null || _b === void 0 ? void 0 : _b.customer,
            manualPaymentTitle: manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.name,
            manualPaymentInstructions: manualPaymentMethod === null || manualPaymentMethod === void 0 ? void 0 : manualPaymentMethod.instructions,
        };
    }
    renderOnHold() {
        var _a, _b, _c;
        if (((_a = this.order) === null || _a === void 0 ? void 0 : _a.status) !== 'processing')
            return null;
        if (((_c = (_b = this === null || this === void 0 ? void 0 : this.order) === null || _b === void 0 ? void 0 : _b.payment_intent) === null || _c === void 0 ? void 0 : _c.processor_type) === 'paypal') {
            return (index.h("sc-alert", { type: "warning", open: true }, wp.i18n.__('Paypal is taking a closer look at this payment. It’s required for some payments and normally takes up to 3 business days.', 'surecart')));
        }
    }
    renderManualInstructions() {
        var _a;
        const paymentMethod = (_a = this.order) === null || _a === void 0 ? void 0 : _a.manual_payment_method;
        if (!(paymentMethod === null || paymentMethod === void 0 ? void 0 : paymentMethod.instructions))
            return;
        return (index.h("sc-alert", { type: "info", open: true }, index.h("span", { slot: "title" }, paymentMethod === null || paymentMethod === void 0 ? void 0 : paymentMethod.name), index.h("div", { innerHTML: paymentMethod === null || paymentMethod === void 0 ? void 0 : paymentMethod.instructions })));
    }
    render() {
        var _a, _b;
        return (index.h(universe.Universe.Provider, { key: 'b659e8338c0273dd7ef253ed4f32464e2146a48b', state: this.state() }, index.h("div", { key: '5d84c1bd84442419ddcb1a982650206689f2058d', class: { 'order-confirmation': true } }, index.h("div", { key: '42624f443d33444d29ec135987f7c849a80ae0b5', class: {
                'order-confirmation__content': true,
                'hidden': !((_a = this.order) === null || _a === void 0 ? void 0 : _a.id) && !this.loading,
            } }, index.h("sc-order-confirm-components-validator", { key: '641a174a2bd69de8cb9fa8b5075b29f2f4c7e06b', checkout: this.order }, index.h("slot", { key: '8cf3285abdcb9a3ffd37df7af8e974d2f433d8a5' }))), !((_b = this.order) === null || _b === void 0 ? void 0 : _b.id) && !this.loading && (index.h("sc-heading", { key: '315539c145ce66fbff3765f63d39738d1ed969da' }, wp.i18n.__('Order not found.', 'surecart'), index.h("span", { key: '3981783f698410bdecccc2429bc5a37faef496ef', slot: "description" }, wp.i18n.__('This order could not be found. Please try again.', 'surecart')))))));
    }
};
ScOrderConfirmation.style = ScOrderConfirmationStyle0;

exports.sc_order_confirmation = ScOrderConfirmation;

//# sourceMappingURL=sc-order-confirmation.cjs.entry.js.map