# Info Box

### Description
Displays an image alongside a heading and description. The entire box can be wrapped in a link.

### Controls
| Control Name | Type | Default | Dynamic Supported | Security Handling |
| --- | --- | --- | --- | --- |
| image | Media | Placeholder | Yes | Native Elementor `Group_Control_Image_Size::get_attachment_image_html()` |
| title_text | text | 'Info Box Title' | Yes | Contextual escaping (`esc_html`) |
| description_text | textarea | 'This is the...' | Yes | Strict XSS sanitization (`RenderHelper::esc_rich_text()`) |
| link | URL | (empty) | Yes | URL protocols sanitized natively by Elementor link wrappers |
| design_variant | select | 'core' | No | Validated against 'core', 'editorial', 'cyber' |

### HTML Structure
```html
<div class="astrax-widget astrax-info-box-wrapper astrax-variant-core">
  <div class="astrax-info-box-image">
    <img src="..." alt="...">
  </div>
  <div class="astrax-info-box-content">
    <h3 class="astrax-info-box-title">Title</h3>
    <div class="astrax-info-box-description">Description text...</div>
  </div>
</div>
```

### Accessibility
- [x] Images generated via native Elementor HTML builder inherit proper `alt` tags from the Media Library.
- [x] Semantic heading (`h3`) is used for the title.
- [x] Link wrapper covers the entire bounding box for a larger tap target.
- [x] Focus state ring for keyboard navigation.

### Quality Status
- Quality Score: 100/100
- Status: PRODUCTION_READY
