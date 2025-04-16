<?php
// XML'i PHP ile alıyoruz
$xml_url = 'https://gallipoliunderwear.com/TicimaxXmlV2/C512FF7F5C4B400D879CF5B8512C4D02/'; // XML kaynağı
$xml_content = simplexml_load_file($xml_url);

// XML içeriğini kontrol et
if ($xml_content === false) {
    echo "XML dosyası alınamadı.";
    exit;
}

// Yeni XML oluşturmak için SimpleXMLElement kullanıyoruz
$xml = new SimpleXMLElement('<Root/>');
$urunler = $xml->addChild('Urunler');

// Ürünleri işliyoruz ve yeni XML verisini ekliyoruz
foreach ($xml_content->Urunler->Urun as $product) {
    $urun = $urunler->addChild('Urun');
    $urun->addChild('Aktif', $product->Aktif);
    $urun->addChild('UrunKartiID', $product->UrunKartiID);
    $urun->addChild('UrunAdi', $product->UrunAdi);
    $urun->addChild('Aciklama', $product->Aciklama);
    $urun->addChild('Marka', $product->Marka);
    $urun->addChild('UrunUrl', $product->UrunUrl);

    // Resimleri ekle
    $resimler = $urun->addChild('Resimler');
    foreach ($product->Resimler->Resim as $image) {
        $resimler->addChild('Resim', $image);
    }

    // Ürün seçeneklerini ekle
    $urunSecenek = $urun->addChild('UrunSecenek');
    foreach ($product->UrunSecenek->Secenek as $option) {
        $secenek = $urunSecenek->addChild('Secenek');
        $secenek->addChild('Aktif', $option->Aktif);
        $secenek->addChild('VaryasyonID', $option->VaryasyonID);
        $secenek->addChild('StokKodu', $option->StokKodu);
        $secenek->addChild('StokAdedi', $option->StokAdedi);
        $secenek->addChild('SatisFiyati', $option->SatisFiyati);
        $secenek->addChild('IndirimliFiyat', $option->IndirimliFiyat);
    }
}

// XML'i çıktıya yazdır
Header('Content-type: text/xml');
echo $xml->asXML();
?>
