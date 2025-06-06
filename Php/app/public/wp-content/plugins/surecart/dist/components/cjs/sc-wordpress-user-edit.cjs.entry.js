'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const fetch = require('./fetch-aaab7645.js');
require('./add-query-args-49dcb630.js');
require('./remove-query-args-b57e8cd3.js');

const scWordpressUserEditCss = ":host{display:block;position:relative}.customer-details{display:grid;gap:0.75em}";
const ScWordpressUserEditStyle0 = scWordpressUserEditCss;

const ScWordPressUserEdit = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.heading = undefined;
        this.successUrl = undefined;
        this.user = undefined;
        this.loading = undefined;
        this.error = undefined;
    }
    renderEmpty() {
        return index.h("slot", { name: "empty" }, wp.i18n.__('User not found.', 'surecart'));
    }
    async handleSubmit(e) {
        this.loading = true;
        try {
            const { email, first_name, last_name, name } = await e.target.getFormJson();
            await fetch.apiFetch({
                path: `wp/v2/users/me`,
                method: 'PATCH',
                data: {
                    first_name,
                    last_name,
                    email,
                    name,
                },
            });
            if (this.successUrl) {
                window.location.assign(this.successUrl);
            }
            else {
                this.loading = false;
            }
        }
        catch (e) {
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
            this.loading = false;
        }
    }
    render() {
        var _a, _b, _c, _d;
        return (index.h("sc-dashboard-module", { key: '918c492a9335adf99ccf9834d0c3174564e8e658', class: "account-details", error: this.error }, index.h("span", { key: '999100523f1572b7b85f4fd3700a05e0ea4702fd', slot: "heading" }, this.heading || wp.i18n.__('Account Details', 'surecart'), " "), index.h("sc-card", { key: 'd12350fd46621b21ba8c1aa1bac28efcb95a8de8' }, index.h("sc-form", { key: '0b103ca1f3ac2f17f25c9d0017f288cb099de691', onScFormSubmit: e => this.handleSubmit(e) }, index.h("sc-input", { key: 'e927f1a6b1006c3adba75ce5b9549c3e635b758a', label: wp.i18n.__('Account Email', 'surecart'), name: "email", value: (_a = this.user) === null || _a === void 0 ? void 0 : _a.email, required: true }), index.h("sc-columns", { key: '47fe57acf5f32fc63703d2e92af3c59773ffdc63', style: { '--sc-column-spacing': 'var(--sc-spacing-medium)' } }, index.h("sc-column", { key: 'ed1f9cf1dd749df4655aa6b695d287caf4f7d86a' }, index.h("sc-input", { key: '52407f9274b55e09a080882db12621500345fe57', label: wp.i18n.__('First Name', 'surecart'), name: "first_name", value: (_b = this.user) === null || _b === void 0 ? void 0 : _b.first_name })), index.h("sc-column", { key: '47d2c630a2ae7508f96bc015a9c5281494f536da' }, index.h("sc-input", { key: '625f6eff33684a33501842de3766990c06036633', label: wp.i18n.__('Last Name', 'surecart'), name: "last_name", value: (_c = this.user) === null || _c === void 0 ? void 0 : _c.last_name }))), index.h("sc-input", { key: '4f595a954e056e7afe4a0691ae0bdb43ac6a6aba', label: wp.i18n.__('Display Name', 'surecart'), name: "name", value: (_d = this.user) === null || _d === void 0 ? void 0 : _d.display_name }), index.h("div", { key: 'aaf42bbaf4d158be639d2214049dd5861f000a07' }, index.h("sc-button", { key: '0af1ea77c02f014f818414f7e20f7afa940c518e', type: "primary", full: true, submit: true }, wp.i18n.__('Save', 'surecart'))))), this.loading && index.h("sc-block-ui", { key: 'f49b0aa8cc69ea4836db7cc0876307ba530219f8', spinner: true })));
    }
};
ScWordPressUserEdit.style = ScWordpressUserEditStyle0;

exports.sc_wordpress_user_edit = ScWordPressUserEdit;

//# sourceMappingURL=sc-wordpress-user-edit.cjs.entry.js.map