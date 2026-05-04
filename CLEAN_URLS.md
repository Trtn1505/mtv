# Clean URLs - Solar Energy Website

## Available URLs

### Public Pages
- `http://yourdomain.com/` - Trang chủ (Homepage)
- `http://yourdomain.com/san-pham` - Danh sách sản phẩm (Products)
- `http://yourdomain.com/du-an` - Danh sách dự án (Projects)
- `http://yourdomain.com/tin-tuc` - Tin tức & Blog (News)
- `http://yourdomain.com/lien-he` - Liên hệ (Contact)

### Admin Panel
- `http://yourdomain.com/admin/login.php` - Admin login

## URL Mapping

| Clean URL | Maps to | Title |
|-----------|---------|-------|
| `/san-pham` | `products.php` | Danh sách sản phẩm |
| `/du-an` | `projects.php` | Danh sách dự án |
| `/tin-tuc` | `posts.php` | Tin tức & bài viết |
| `/lien-he` | `contact.php` | Biểu mẫu liên hệ |

## How It Works

- **Technology**: Apache URL Rewriting via `.htaccess`
- **Original Files**: Still exist (e.g., `products.php`, `projects.php`)
- **Backward Compatibility**: Old URLs still work (redirected silently)
- **SEO Friendly**: Clean URLs are better for search engines
- **User Friendly**: URLs are more readable and memorable

## .htaccess Configuration

```apache
RewriteRule ^san-pham/?$ /products.php [L,QSA]
RewriteRule ^du-an/?$ /projects.php [L,QSA]
RewriteRule ^tin-tuc/?$ /posts.php [L,QSA]
RewriteRule ^lien-he/?$ /contact.php [L,QSA]
```

## Notes

- Trailing slashes are optional (both `/san-pham` and `/san-pham/` work)
- Query strings are preserved (`?page=2`, etc.)
- Real files and directories are not affected
- Works on Apache servers with `mod_rewrite` enabled

---

**For hosting providers**: Ensure that `mod_rewrite` is enabled and `.htaccess` files are allowed.
