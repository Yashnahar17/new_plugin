# WooCommerce Product Grid

### Description
A flexible, high-converting WooCommerce product showcase widget supporting queries by category, tag, sale status, or featured items, complete with add-to-cart triggers and design variants.

### Controls
| Control Name | Type | Default | Dynamic Supported | Security Handling |
| --- | --- | --- | --- | --- |
| products_count | number | 6 | No | Absolute integer cast (`absint`) |
| columns | responsive select | 3 | No | Whitelisted column counts |
| filter_by | select | 'recent' | No | Whitelisted product query modes |
| design_variant | select | 'core' | No | `sanitize_key()` validation |
| show_price | switcher | 'yes' | No | Boolean check |
| show_rating | switcher | 'yes' | No | Boolean check |
| show_add_to_cart | switcher | 'yes' | No | Boolean check |

### HTML Structure
```html
<div class="astrax-widget astrax-woo-product-grid astrax-variant-core">
  <div class="astrax-woo-grid-inner">
    <div class="astrax-product-card product">
      <div class="astrax-product-image">...</div>
      <h4 class="astrax-product-title"><a href="...">Product Name</a></h4>
      <div class="astrax-product-price"><span class="woocommerce-Price-amount">...</span></div>
      <div class="astrax-product-actions"><a href="..." class="button add_to_cart_button">Add to cart</a></div>
    </div>
  </div>
</div>
```

### Accessibility
- [x] Clear product title links with accessible labels.
- [x] Standard WooCommerce price formatting with currency screen reader semantics.
- [x] Accessible Add to Cart buttons with ARIA announcements on completion.
- [x] Responsive column collapsing on tablet and mobile viewports.

### Quality Status
- Quality Score: 100/100
- Status: PRODUCTION_READY
