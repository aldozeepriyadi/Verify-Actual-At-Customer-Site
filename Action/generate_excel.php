<?php
include ("../config.php");
include ("../session.php");

// Include PHPExcel
require_once '../lib/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../lib/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

$dock_customer = isset($_POST['dock_customer']) ? $_POST['dock_customer'] : '';
$dock_kybi = isset($_POST['dock_kybi']) ? $_POST['dock_kybi'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';
$search = isset($_POST['search']) ? $_POST['search'] : '';

$sqlMonitoring = "SELECT 
    vd.kyb_id_verfikasi,
    lc.kyb_bpid, 
    lc.kyb_cycle,
    lc.kyb_dock_customer,
    lc.kyb_longi,
    lc.kyb_lat, 
    sd.kyb_qty_palet, 
    sd.kyb_plan_arrival,
    sd.kyb_id_schedule, 
    sd.kyb_waktu, 
    sd.kyb_dock_kybi,
    vd.kyb_actual_arrival,
    usr.kyb_nama_usr,
    TIMESTAMPDIFF(MINUTE, sd.kyb_plan_arrival, vd.kyb_actual_arrival) AS delay_minutes,
    IF(sd.kyb_plan_arrival >= vd.kyb_actual_arrival, 'On Time', 'Be late') AS status
FROM 
    kyb_trscheduledelivery sd
LEFT JOIN 
    kyb_trsverifikasikedatangan vd ON sd.kyb_id_schedule = vd.kyb_id_schedule
LEFT JOIN 
    kyb_mslokasicustomer lc ON sd.kyb_id_lokasicustomer = lc.kyb_id_lokasicustomer
LEFT JOIN
    kyb_msuser usr ON sd.kyb_id_usr = usr.kyb_id_usr
WHERE sd.kyb_status = 3 AND vd.kyb_status = 1 AND usr.kyb_id_role = 1 ";

if ($dock_customer !== '') {
    $sqlMonitoring .= " AND lc.kyb_dock_customer = '$dock_customer'";
}
if ($dock_kybi !== '') {
    $sqlMonitoring .= " AND sd.kyb_dock_kybi = '$dock_kybi'";
}
if ($status !== '') {
    $sqlMonitoring .= " AND IF(sd.kyb_plan_arrival >= vd.kyb_actual_arrival, 'On Time', 'Be late') = '$status'";
}
if ($search !== '') {
    $sqlMonitoring .= " AND (
        lc.kyb_cycle LIKE '%$search%' OR
        lc.kyb_dock_customer LIKE '%$search%' OR
        sd.kyb_dock_kybi LIKE '%$search%' OR
        usr.kyb_nama_usr LIKE '%$search%' OR
        vd.kyb_actual_arrival LIKE '%$search%' OR
        sd.kyb_qty_palet LIKE '%$search%' OR
        IF(sd.kyb_plan_arrival >= vd.kyb_actual_arrival, 'On Time', 'Be late') LIKE '%$search%'
    )";
}

$result = mysqli_query($conn, $sqlMonitoring);

if (!$result) {
    echo json_encode(array('error' => mysqli_error($conn)));
    exit;
}

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$sheet = $objPHPExcel->getActiveSheet();

// Menambahkan logo
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../assets/img/kyb-merah.png'); // Path ke file gambar logo
$objDrawing->setHeight(36);
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($sheet);

// Menambahkan judul dan header tabel
$sheet->mergeCells('A2:I2');
$sheet->setCellValue('A2', 'Monitoring Data Driver');
$sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->mergeCells('A3:I3');
$sheet->setCellValue('A3', 'PT Kayaba Indonesia');
$sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);
$sheet->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$sheet->setCellValue('A5', 'No');
$sheet->setCellValue('B5', 'Cycle');
$sheet->setCellValue('C5', 'Dock Customer');
$sheet->setCellValue('D5', 'Dock Kayaba');
$sheet->setCellValue('E5', 'Nama Driver');
$sheet->setCellValue('F5', 'Actual Arrival');
$sheet->setCellValue('G5', 'Quantity Pallet');
$sheet->setCellValue('H5', 'Status');
$sheet->setCellValue('I5', 'Delay Minutes');

$sheet->getStyle('A5:I5')->getFont()->setBold(true)->getColor()->setRGB('FFFFFF');
$sheet->getStyle('A5:I5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('000000');

// Mengatur lebar kolom
$sheet->getColumnDimension('A')->setWidth(5);
$sheet->getColumnDimension('B')->setWidth(20);
$sheet->getColumnDimension('C')->setWidth(25);
$sheet->getColumnDimension('D')->setWidth(25);
$sheet->getColumnDimension('E')->setWidth(30);
$sheet->getColumnDimension('F')->setWidth(20);
$sheet->getColumnDimension('G')->setWidth(10);
$sheet->getColumnDimension('H')->setWidth(15);
$sheet->getColumnDimension('I')->setWidth(20);

// Mengisi data dari database
$i = 6;
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $sheet->setCellValue('A' . $i, $no);
    $sheet->setCellValue('B' . $i, $row['kyb_cycle']);
    $sheet->setCellValue('C' . $i, $row['kyb_dock_customer']);
    $sheet->setCellValue('D' . $i, $row['kyb_dock_kybi']);
    $sheet->setCellValue('E' . $i, $row['kyb_nama_usr']);
    $sheet->setCellValue('F' . $i, $row['kyb_actual_arrival']);
    $sheet->setCellValue('G' . $i, $row['kyb_qty_palet']);
    $sheet->setCellValue('H' . $i, $row['status']);

    $delay_minutes = $row['delay_minutes'] > 0 ? $row['delay_minutes'] . ' minutes' : '-';
    $sheet->setCellValue('I' . $i, $delay_minutes);

    // Tambahkan border ke setiap sel
    $sheet->getStyle('A' . $i . ':I' . $i)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    $i++;
    $no++;
}

// Tambahkan border ke header tabel
$sheet->getStyle('A5:I5')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

// Menyimpan file Excel ke server
$filename = 'monitoring_data_' . date('YmdHis') . '.xlsx';
$filepath = '../uploads/excel/' . $filename; // Pastikan path ini valid dan direktori memiliki izin tulis
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($filepath);

// Mengirimkan path file sebagai respons
echo json_encode(array('file' => $filename, 'path' => $filepath));
?>