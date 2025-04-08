
INSERT INTO `nhà_cung_cấp` (`Mã nhà cung cấp`, `tên nhà cung cấp`, `địa chỉ`, `sđt`, `mô tả`, `created_at`, `updated_at`) VALUES
('B01', 'Bình', 'Sông Công', 356627865, 'ok', '2023-04-06 10:16:05', '2023-04-06 10:16:05');

INSERT INTO `loại_nguyên_liệu` (`ID_loại_nguyên_liệu`, `tên loại nguyên liệu`, `mô tả`, `created_at`, `updated_at`) VALUES
(1, 'Thực phẩm', 'ok', '2023-04-06 10:16:34', '2023-04-06 10:16:34');

INSERT INTO `nguyên_liệu` (`Mã nguyên liệu`, `tên nguyên liệu`, `mô tả`, `đơn vị tính`, `barcode`, `số lượng`, `image`, `Loại nguyên liệu`, `created_at`, `updated_at`) VALUES
('MT01', 'Mì tôm hảo hảo', 'ok', 'Gói', 123123123, 100, '1680776320.png', 1, '2023-04-06 10:18:40', '2023-04-06 10:18:40');

INSERT INTO `cơ_sở` (`Mã cơ sở`, `tên cơ sở`, `mô tả`, `trạng thái`, `created_at`, `updated_at`) VALUES
('CS01', 'Cơ sở 1', 'ok', 3, '2023-04-06 10:18:40', '2023-04-06 10:18:40');

INSERT INTO `phiếu_nhập` (`Mã phiếu nhập`, `ngày nhập`, `mô tả`, `tổng tiền`, `Mã NCC`, `ID_user`, `created_at`, `updated_at`) VALUES
('PN000001', '2023-04-06', 'ok', 360000, 'B01', 1, '2023-04-06 10:19:37', '2023-04-06 10:19:37');

INSERT INTO `chi_tiết_phiếu_nhập` (`Mã phiếu nhập`, `Mã nguyên liệu`, `số lượng nhập`, `giá nhập`, `ngày sản xuất`, `thời gian bảo quản`, `created_at`, `updated_at`) VALUES
('PN000001', 'MT01', 90, 4000, '2023-04-06', 24, '2023-04-06 10:19:37', '2023-04-06 10:20:38');

INSERT INTO `phiếu_xuất` (`Mã phiếu xuất`, `ngày xuất`, `mô tả`, `tổng tiền`, `ID cơ sở`, `ID_user`, `created_at`, `updated_at`) VALUES
('PX000001', '2023-04-06', 'ok', 50000, 'CS01', 1, '2023-04-06 10:20:38', '2023-04-06 10:20:38');

INSERT INTO `chi_tiết_phiếu_xuất` (`Mã phiếu xuất`, `Mã nguyên liệu`, `số lượng xuất`, `giá xuất`, `created_at`, `updated_at`) VALUES
('PX000001', 'MT01', 10, 5000, '2023-04-06 10:20:38', '2023-04-06 10:20:38');
