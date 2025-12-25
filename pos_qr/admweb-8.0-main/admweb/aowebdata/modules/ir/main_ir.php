<?php
PERMIT::_PERMIT(_MODULE_, 'module|mp|keysname', 'สามารถเปิด Articles ได้', 'redirect', 'SET');
/*
$url = "https://www.set.or.th/th/market/product/stock/quote/WHA/company-profile/information"; // ตัวอย่างหน้า PTT
$html = file_get_contents($url);

if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
    $bodyContent = $matches[1]; // เฉพาะเนื้อหาที่อยู่ใน body
} else {
    $bodyContent = "ไม่พบ body";
}


libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($bodyContent);
$xpath = new DOMXPath($doc);
$nodes = $xpath->query("//*[contains(@class,'value') 
                       and contains(@class,'text-white') 
                       and contains(@class,'mb-0') 
                       and contains(@class,'me-2') 
                       and contains(@class,'lh-1') 
                       and contains(@class,'stock-info')]");
$result = '';
if ($nodes->length > 0) {
    foreach ($nodes as $node) {
        $result = trim($node->textContent) . PHP_EOL; // ได้เฉพาะข้อความที่อยู่ใน tag นั้น
    }
} else {
    $result = "ไม่พบข้อมูล";
}




// ดึง h3 ที่มี class d-flex mb-0 pb-2 theme-danger

$nodes = $xpath->query("//h3[contains(@class,'d-flex') 
                        and contains(@class,'mb-0') 
                        and contains(@class,'pb-2') 
                        and contains(@class,'theme-danger')]");

if ($nodes->length > 0) {
    foreach ($nodes as $node) {
        // วิธีที่ 1: ได้ข้อความรวมทั้งหมด เช่น "-0.14 (-5.98%)"
        //echo trim($node->textContent) . PHP_EOL;

        // วิธีที่ 2: ดึง <span> แยกเป็นค่า กับเปอร์เซ็นต์
        $spans = $node->getElementsByTagName("span");
        if ($spans->length >= 2) {
            $value = trim($spans->item(0)->textContent);
            $percent = trim($spans->item(1)->textContent);
            $result .= "ค่าการเปลี่ยนแปลง: $value" . PHP_EOL;
            $result .= "เปอร์เซ็นต์: $percent" . PHP_EOL;
        }
    }
} else {
    $result .= "ไม่พบข้อมูล";
}

/*
$nodes = $xpath->query("//div[contains(@class,'company-info') and contains(@class,'site-container')]");

$result = "";
if ($nodes->length > 0) {
    $result = $doc->saveHTML($nodes->item(0));
} else {
    $result = "ไม่พบ div company-info site-container";
}
*/
// แสดงผล
//echo $result;

/*
if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $html, $matches)) {
    $bodyContent = $matches[1]; // เฉพาะเนื้อหาที่อยู่ใน body
} else {
    $bodyContent = "ไม่พบ body";
}
*/
?>
<div id="page-content">
    <div class="row">
        <div class="col-md-12">
            <?php echo displayRaiseMsg(); ?>
            <textarea style="width:100%; height:800px;padding: 20px;"><?php //echo $result; ?></textarea>
        </div>
    </div>
</div>