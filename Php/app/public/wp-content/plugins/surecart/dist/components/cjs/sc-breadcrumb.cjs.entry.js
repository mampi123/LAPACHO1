'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scBreadcrumbCss = ":host{display:inline-flex}.breadcrumb-item{display:inline-flex;align-items:center;font-family:var(--sc-font-sans);font-size:var(--sc-font-size-small);font-weight:var(--sc-font-weight-semibold);color:var(--sc-breadcrumb-color, var(--sc-color-gray-600));line-height:var(--sc-line-height-normal);white-space:nowrap}.breadcrumb-item__label{display:inline-block;font-family:inherit;font-size:inherit;font-weight:inherit;line-height:inherit;text-decoration:none;color:inherit;background:none;border:none;border-radius:var(--sc-border-radius-medium);padding:0;margin:0;cursor:pointer;transition:color var(--sc-transition-fast) ease}:host(:not(:last-of-type)) .breadcrumb-item__label{color:var(--sc-breadcrumb-item-label-color, var(--sc-color-gray-900))}:host(:not(:last-of-type)) .breadcrumb-item__label:hover{color:var(--sc-breadcrumb-item-label-hover-color, var(--sc-color-primary-500))}:host(:not(:last-of-type)) .breadcrumb-item__label:active{color:var(--sc-breadcrumb-item-label-active-color, var(--sc-color-gray-900))}.breadcrumb-item__label:focus{box-shadow:var(--sc-focus-ring)}.breadcrumb-item__prefix,.breadcrumb-item__suffix{display:none;flex:0 0 auto;display:flex;align-items:center}.breadcrumb-item--has-prefix .breadcrumb-item__prefix{display:inline-flex;margin-right:var(--sc-spacing-x-small)}.breadcrumb-item--has-suffix .breadcrumb-item__suffix{display:inline-flex;margin-left:var(--sc-spacing-x-small)}:host(:last-of-type) .breadcrumb-item__separator{display:none}.breadcrumb-item__separator{display:inline-flex;align-items:center;margin:0 var(--sc-spacing-x-small);user-select:none}";
const ScBreadcrumbStyle0 = scBreadcrumbCss;

const ScBreadcrumb = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.href = undefined;
        this.target = undefined;
        this.rel = 'noreferrer noopener';
        this.hasPrefix = undefined;
        this.hasSuffix = undefined;
    }
    handleSlotChange() {
        this.hasPrefix = !!this.el.querySelector('[slot="prefix"]');
        this.hasSuffix = !!this.el.querySelector('[slot="suffix"]');
    }
    render() {
        const Tag = this.href ? 'a' : 'div';
        return (index.h("div", { key: '11d4677b519ba8906160d1752969037a74cdc909', part: "base", class: {
                'breadcrumb-item': true,
                'breadcrumb-item--has-prefix': this.hasPrefix,
                'breadcrumb-item--has-suffix': this.hasSuffix,
            } }, index.h("span", { key: '6137150f3b1b78a9eef921a0c80f1f8ce5cf01fa', part: "prefix", class: "breadcrumb-item__prefix" }, index.h("slot", { key: 'ae516bd2f02485088aadfe109568fbf0ef0c4d4e', name: "prefix" })), index.h(Tag, { key: '8f8d814ed9eb61b4497970df073492c220123223', part: "label", class: "breadcrumb-item__label breadcrumb-item__label--link", href: this.href, target: this.target, rel: this.rel }, index.h("slot", { key: '9d30c3707cb61bee4d600c53c68e7dade736b8f0' })), index.h("span", { key: '9f2ab753dd4ec00c5521d7575dc7d08c9298859f', part: "suffix", class: "breadcrumb-item__suffix" }, index.h("slot", { key: '8e2fb94074d947bbee85422c6e02678dc11c9f8f', name: "suffix", onSlotchange: () => this.handleSlotChange() })), index.h("span", { key: '8e302ebe75ff6829237fc305e56d4f35496c0274', part: "separator", class: "breadcrumb-item__separator", "aria-hidden": "true" }, index.h("slot", { key: '275587b6f0c297c89b8c4680383880cc1cc4ce92', name: "separator", onSlotchange: () => this.handleSlotChange() }, index.h("sc-icon", { key: '07d968ad59d3ece97a70b9906d11f18fd2f8ac6c', name: "chevron-right" })))));
    }
    get el() { return index.getElement(this); }
};
ScBreadcrumb.style = ScBreadcrumbStyle0;

exports.sc_breadcrumb = ScBreadcrumb;

//# sourceMappingURL=sc-breadcrumb.cjs.entry.js.map