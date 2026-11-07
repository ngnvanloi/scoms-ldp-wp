# scoms-ldp-wp

Landing page sự kiện cho scommunicationsgroup.com.
Code giao diện bằng HTML/CSS, khách duyệt qua GitHub Pages, sau đó đóng gói thành plugin Elementor để khách tự sửa nội dung trên WordPress.

## Cấu trúc

```
prototype/                    Trang HTML preview (GitHub Pages)
  index.html                  Mỗi section là một thẻ <section class="scl scl-<tên>">
  images/                     Ảnh tạm cho preview (trên WP khách chọn ảnh từ Media Library)
  dev/                        Chỉ dùng khi dev: header/footer giả + CSS theme giả lập
plugin/scoms-landing/         Plugin WordPress
  scoms-landing.php           File chính: danh sách widget, đăng ký CSS/JS
  widgets/class-<x>.php       Mỗi section = 1 widget Elementor
  assets/css/                 CSS DÙNG CHUNG cho cả prototype và plugin (chỉ có 1 bản)
  assets/js/                  JS dùng chung
scripts/build.ps1             Tạo dist/scoms-landing-<version>.zip
scripts/link-localwp.ps1      Nối plugin vào site LocalWP
```

CSS và JS chỉ có **một bản**, nằm trong `plugin/scoms-landing/assets/`. Prototype link thẳng tới đó, nên preview và WordPress luôn giống nhau.

## Quy ước code

- Toàn bộ code bằng tiếng Anh (tên biến, class, label trong panel Elementor). Chỉ nội dung hiển thị trên giao diện mới viết tiếng Việt.
- Không viết comment trong code. Ngoại lệ duy nhất: khối header `Plugin Name: ...` trong `scoms-landing.php`, vì WordPress cần khối này để nhận plugin.

## Quy tắc CSS (để không xung đột với theme)

- Gốc mỗi section: `<section class="scl scl-<tên>">`.
- Selector luôn viết dạng `.scl .scl-<tên>__<phần>`, còn gốc section là `.scl.scl-<tên>`.
- Không style thẻ trần (`body`, `h1`, `a`, `*`) hay class chung (`.container`, `.btn`).
- Cỡ chữ dùng `em` hoặc `px`, **không dùng `rem`**.
- Link hoặc nút có màu riêng thì viết thêm rule `:hover`.
- JS: vanilla, bọc trong IIFE, không dùng jQuery, không thêm Swiper (Elementor đã có sẵn Swiper).
- Kiểm tra bằng cách mở prototype với `?theme`. Nếu section nào bị đổi giao diện thì CSS của section đó chưa đủ chắc.

## 1. Làm giao diện (prototype)

1. Mở thư mục repo bằng VS Code, cài extension **Live Server**.
2. Chuột phải `prototype/index.html`, chọn *Open with Live Server*.
3. Kiểm tra cả hai chế độ:
   - `.../prototype/index.html`: CSS sạch
   - `.../prototype/index.html?theme`: giả lập CSS hung hãn của theme và Elementor. Giao diện phải **giống hệt** chế độ trên.

## 2. Gửi khách duyệt (GitHub Pages)

Thiết lập một lần: GitHub repo > *Settings > Pages > Source* chọn **GitHub Actions**.

Sau đó mỗi lần `git push` lên `master`, link tự cập nhật sau khoảng 1 phút:
`https://ngnvanloi.github.io/scoms-ldp-wp/`

## 3. Thử trên WordPress local (LocalWP)

1. Cài [LocalWP](https://localwp.com) và tạo site tên `scoms`.
2. Trong LocalWP chọn *Open site shell*, chạy:
   ```
   wp plugin install elementor --version=4.3.6 --activate
   wp theme install hello-elementor --activate
   ```
3. Nối plugin vào site, chạy trong PowerShell ở thư mục repo:
   ```
   powershell -ExecutionPolicy Bypass -File scripts\link-localwp.ps1 -SiteName scoms
   ```
4. wp-admin > *Plugins*, kích hoạt **SCOMS Landing**.
5. Tạo trang mới và chọn *Edit with Elementor*:
   - Bánh răng (Page Settings) > *Page Layout*: **Elementor Full Width**, bật *Hide Title*.
   - Thêm 1 Container, chỉnh *Content Width*: Full Width, *Padding*: 0, *Gap*: 0.
   - Tìm nhóm **SCOMS Landing** và kéo **Hero** rồi **Agenda** vào.
   - Widget Agenda: tab *Advanced > CSS ID* điền `chuong-trinh` để nút ở Hero cuộn xuống được.
6. Bật debug trong `wp-config.php` của site local:
   ```php
   define( 'WP_DEBUG', true );
   define( 'WP_DEBUG_LOG', true );
   define( 'WP_DEBUG_DISPLAY', false );
   ```
   Lỗi PHP sẽ được ghi vào `wp-content/debug.log`.

Sửa CSS/JS/PHP trong repo, tải lại trang là thấy ngay. Nếu chỉnh màu/thanh trượt trong panel mà không thấy đổi: *Elementor > Tools > Regenerate CSS & Data*.

## 4. Đưa lên site thật

1. Tăng `Version` trong header của `plugin/scoms-landing/scoms-landing.php`.
2. Tạo file zip:
   ```
   powershell -ExecutionPolicy Bypass -File scripts\build.ps1
   ```
3. Commit, tạo tag `vX.Y.Z`, push.
4. Site thật: *Plugins > Add New > Upload Plugin*, chọn `dist/scoms-landing-X.Y.Z.zip`.
   - Lần cập nhật sau: WordPress sẽ hỏi thay thế bản cũ, chọn *Replace current with uploaded*.
5. Mở trang chủ và vài trang khác ở tab ẩn danh. Có lỗi thì vào *Plugins* bấm **Deactivate**.
6. Dựng trên **trang nháp**, gửi link preview cho khách, khách đồng ý rồi mới Publish.

## Thêm section mới

1. Viết HTML trong `prototype/index.html` (một thẻ `<section class="scl scl-<tên>">`) và tạo `assets/css/<tên>.css`, rồi link file CSS đó trong `<head>` của prototype.
2. Copy `widgets/class-agenda.php` (danh sách) hoặc `class-hero.php` (nội dung đơn), đổi tên class, `get_name()` thành `scl_<tên>`, `get_style_depends()` thành `scl-<tên>`.
3. Dán HTML vào `render()`, thay nội dung cứng bằng `$s['...']` (chữ bọc `esc_html`, thuộc tính bọc `esc_attr`).
4. Thêm 1 dòng vào `scl_widgets()` trong `scoms-landing.php`.

**Sau khi đã lên site thật, không đổi tên hay xoá ID của control** (`'title'`, `'items'`...). Nội dung khách đã nhập gắn với các ID đó. Thêm control mới thì không sao.
