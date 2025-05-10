<?php

namespace frontend\components;

use backend\modules\donation_types\models\DonationTypes;

class HistoryPdf extends \TCPDF
{
    public function AddPage($orientation = '', $format = '', $keepmargins = false, $tocpage = false)
    {
        parent::AddPage($orientation, $format, $keepmargins, $tocpage);
        $this->setRTL(false);
        $this->Image(__DIR__ . DIRECTORY_SEPARATOR . "bg.png",  0,  0, $this->getPageWidth() , $this->getPageHeight());
        $this->setRTL(true);
        $this->setY(50);
    }

    private function limitWords($text, $limit = 4, $suffix = '...') {
        $words = explode(' ', $text);
        if (count($words) <= $limit) {
            return $text;
        }
        return implode(' ', array_slice($words, 0, $limit)) . $suffix;
    }

    private function ColoredTable($header,$data, $total) {
        $this->SetFillColor(4, 3, 66);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('dejavusans', 'B');

        $w = array(40, 40, 40, 0);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 10, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        $this->SetTextColor(4, 3, 66);
        $this->SetFont('dejavusans');

        foreach($data as $row) {
            $this->Cell($w[0], 10, $row[0], 'LRB', 0, 'C');
            $this->Cell($w[1], 10, number_format($row[1], 2), 'LRB', 0, 'C');
            $this->Cell($w[2], 10, $row[2], 'LRB', 0, 'C');
            $this->Cell($w[3], 10, $this->limitWords($row[3]), 'LRB', 0, 'C');
            $this->Ln();
        }

        if ($total){
            $this->Cell($w[0], 10, 'الاجمالي', 'LRB', 0, 'C');
            $this->Cell($w[1], 10, number_format($total, 2) . " دينار", 'LRB', 0, 'C');
        }
    }

    public function generate($chunks, $donor, $start_date, $end_date){
        $total = 0;
        [$id, $all_users, $name] = explode("|", $donor);
        foreach ($chunks as $index => $chunk){
            $this->AddPage();
            $html = '';
            if ($index == 0){
                $date = date('Y-m-d');
                $html .= '<p style="line-height: 25px">';
                $html .= 'تاريخ اصدار الكشف: ' . "<b style='font-weight: bold'>$date</b>" . '<br>';
                $html .= 'اسم المتبرع: ' . "<b style='font-weight: bold'>$name</b>" . '<br>';
                if ($start_date){
                    $html .= 'جدول التبرعات المقدمة للفترة : ';
                    $html .= $start_date;
                    if ($end_date)
                        $html .= " - " . $end_date;
                }
                $html .= '<br>';
                $html .= '</p>';

                $this->writeHTML($html);
            }

            $header = [
                'رقم السند',
                'المبلغ',
                'تاريخ القبض',
                'نوع التبرع'
            ];

            $data = [];
            foreach ($chunk as $item){
                $donation_type = DonationTypes::find()->where(['guid' => $item['DonationType']])->one();

                if (!$donation_type) {
                    continue;
                }

                $item['Amount'] = $item['Amount'] * $item['Quantity'];
                $item['DonationDate'] = new \DateTime($item['DonationDate']);
                $item['title'] = $donation_type->title;
                $total += (float)$item['Amount'] * (float) $item['Quantity'];

                $data[] = [$item['DonationID'], $item['Amount'], $item['DonationDate']->format('Y-m-d H:i'), $item['title']];
            }
            $this->ColoredTable($header, $data, ($index == count($chunks) - 1) ? $total : 0);
        }

        $this->AddPage();
        $this->setTextColor(0);
        $this->setY(70);
        $this->writeHTML("<h4>دمتم سباقين لعمل الخير فمعكم نتمكن من اطعام الأسر الأكثر حاجة.</h4>");
        $this->writeHTMLCell(0, 0, '', 90, "<h4>وتفضلوا بقبول فائق الإحترام،،،</h4>", 0, 1, 0, true, 'C', true);
        $this->setFont('dejavusans', '', 9);
        $this->writeHTMLCell(0, 0, '', 130, "<ul><li>هذا التقرير مؤتمت وصادر من النظام الخاص بتكية أم علي</li><li>تبرعك معفي من ضريبة الدخل بنسبة 100%على أن لا تتجاوز قيمة التبرع25% من الدخل السنوي</li></ul>");
        $this->setFont('dejavusans', '', 12);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}