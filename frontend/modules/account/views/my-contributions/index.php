<?php

use yii\widgets\Pjax;

$this->params['mainIdName'] = "contributions";
$this->title = Yii::t('site', 'My Contributions');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/contributions.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

<div class="total-donations">
    <h3>My total donations</h3>
    <h3>1,384 JOD</h3>
</div>
<div class="impact-inputs">
    <h3>My impact</h3>
    <div class="d-flex gap-2">
        <div class="col-6  d-flex flex-column gap-2 mb-3">
            <label for="date">from </label>
            <input type="date" name="date" id="date" placeholder=" DD/MM/YYYY">
        </div>
        <div class=" col-6  d-flex flex-column gap-2 mb-3">
            <label for="date">to  </label>
            <input type="date" name="date" id="date" placeholder="DD/MM/YYYY ">
        </div>
    </div>
</div>
<!--<div class="contributions-chart-section">-->
<!--    <div class="contributions-box">-->
<!--        <div>-->
<!--            <h4>I contributed today</h4>-->
<!--            <p>Feeding 12 persons</p>-->
<!--            <div class="chart-labels">-->
<!--                <div class="label-item">-->
<!--                    <p>Children:</p>-->
<!--                    <p>4</p>-->
<!--                </div>-->
<!--                <div class="label-item">-->
<!--                    <p>Older people:</p>-->
<!--                    <p>6</p>-->
<!--                </div>-->
<!--                <div class="label-item">-->
<!--                    <p>Helpless:</p>-->
<!--                    <p>2</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <canvas id="contributionChart"></canvas>-->
<!--    </div>-->
<!--    <div class="contributions-box">-->
<!--        <div>-->
<!--            <h4>The effect of Udhiyah & Dabiha</h4>-->
<!--            <p>Feeding 15 persons</p>-->
<!--            <div class="chart-labels">-->
<!--                <div class="label-item">-->
<!--                    <p>Children:</p>-->
<!--                    <p>3</p>-->
<!--                </div>-->
<!--                <div class="label-item">-->
<!--                    <p>Older people:</p>-->
<!--                    <p>2</p>-->
<!--                </div>-->
<!--                <div class="label-item">-->
<!--                    <p>Helpless:</p>-->
<!--                    <p>10</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <canvas id="contributionChart2"></canvas>-->
<!--    </div>-->
<!--</div>-->
<div class="donation-schemes">
    <h4>Total donation schemes supported</h4>
    <p>7/15 schemes</p>
    <div class="donation-schemes-items">
        <div class="donation-schemes-1st-col">
            <div class="donation-schemes-item">
                <p>To our children in Jordan and Gaza:</p>
                <p>1</p>
            </div>
            <div class="donation-schemes-item">
                <p>child to child:</p>
                <p>0</p>
            </div>
            <div class="donation-schemes-item">
                <p>Udhiyah & Dhabihah:</p>
                <p>0</p>
            </div>
            <div class="donation-schemes-item">
                <p>Your Zakat Reaches Jordan and Gaza:</p>
                <p>0</p>
            </div>
            <div class="donation-schemes-item">
                <p>Contribute to Feeding a Family in Need:</p>
                <p>3</p>
            </div>
            <div class="donation-schemes-item">
                <p>Perpetual Charity (Sadaqa Jariyah) -Back to School Campaign:</p>
                <p>2</p>
            </div>
            <div class="donation-schemes-item">
                <p>Gaza Campaign:</p>
                <p>8</p>
            </div>
            <div class="donation-schemes-item">
                <p>Family Sponsorships:</p>
                <p>0</p>
            </div>
        </div>
        <div class="donation-schemes-2nd-col">
            <div class="donation-schemes-item">
                <p>Monthly Food Parcels:</p>
                <p>0</p>
            </div>
            <div class="donation-schemes-item">
                <p>Sadaqa:</p>
                <p>0</p>
            </div>
            <div class="donation-schemes-item">
                <p>Donate your Gift</p>
                <p>0</p>
            </div>
            <div class="donation-schemes-item">
                <p>Iftar Meals:</p>
                <p>0</p>
            </div>
            <div class="donation-schemes-item">
                <p>Ramadan Kaffarah:</p>
                <p>13</p>
            </div>
            <div class="donation-schemes-item">
                <p>Friday Sadaqa:</p>
                <p>293</p>
            </div>
            <div class="donation-schemes-item">
                <p>Wayfarer (Daily Hot Meals):</p>
                <p>5</p>
            </div>
        </div>
    </div>

</div>

<?php
//$js = <<<JS
//    const ctx = document.getElementById('contributionChart').getContext('2d');
//
//    const data = {
//        labels: ['Children', 'Older people', 'Helpless'],
//        datasets: [{
//            data: [4, 6, 2],
//            backgroundColor: ['rgba(178, 204, 40, 1)', 'rgba(243, 162, 23, 1)', 'rgba(206, 90, 157, 1)'],
//            borderWidth: 0
//        }]
//    };
//
//    const options = {
//        plugins: {
//            legend: {
//                display: false // Hide the legend
//            },
//            tooltip: {
//                callbacks: {
//                    label: function (context) {
//                        const label = context.label || '';
//                        const value = context.raw || 0;
//                        return `\${label}: \${value}`;
//                    }
//                }
//            }
//        },
//        responsive: true,
//        maintainAspectRatio: false,
//        cutout: '80%', // Decrease thickness
//        hover: {
//            mode: null // Disable hover effects
//        },
//        animation: {
//            duration: 0 // Disable animations
//        }
//    };
//
//    const contributionChart = new Chart(ctx, {
//        type: 'doughnut',
//        data: data,
//        options: options,
//        plugins: [
//            {
//                id: 'customText',
//                beforeDraw(chart) {
//                    const { width } = chart;
//                    const { height } = chart;
//                    const ctx = chart.ctx;
//                    ctx.save();
//
//                    // Add text in the center
//                    const text = '12 persons';
//                    ctx.font = '1rem Alexandria';
//                    ctx.fillStyle = 'rgba(4, 30, 66, 1)';
//                    ctx.textAlign = 'center';
//                    ctx.textBaseline = 'middle';
//                    ctx.fillText(text, width / 2, height / 2);
//
//                    ctx.restore();
//                }
//            }
//        ]
//    });
//
//        const ctx2 = document.getElementById('contributionChart2').getContext('2d');
//
//    const data2 = {
//        labels: ['Children', 'Older people', 'Helpless'],
//        datasets: [{
//            data: [3, 2, 10], // Corrected data for the second chart
//            backgroundColor: ['rgba(178, 204, 40, 1)', 'rgba(243, 162, 23, 1)', 'rgba(206, 90, 157, 1)'],
//            borderWidth: 0
//        }]
//    };
//
//    const options2 = {
//        plugins: {
//            legend: {
//                display: false // Hide the legend
//            },
//            tooltip: {
//                callbacks: {
//                    label: function (context) {
//                        const label = context.label || '';
//                        const value = context.raw || 0;
//                        return `\${label}: \${value}`;
//                    }
//                }
//            }
//        },
//        responsive: true,
//        maintainAspectRatio: false,
//        cutout: '80%', // Decrease thickness
//        hover: {
//            mode: null // Disable hover effects
//        },
//        animation: {
//            duration: 0 // Disable animations
//        }
//    };
//
//    const contributionChart2 = new Chart(ctx2, {
//        type: 'doughnut',
//        data: data2, // Use data2
//        options: options2, // Use options2
//        plugins: [
//            {
//                id: 'customText',
//                beforeDraw(chart) {
//                    const { width } = chart;
//                    const { height } = chart;
//                    const ctx = chart.ctx;
//                    ctx.save();
//
//                    // Add text in the center
//                    const text = '15 persons'; // Updated text for the second chart
//                    ctx.font = '1rem Alexandria';
//                    ctx.fillStyle = 'rgba(4, 30, 66, 1)';
//                    ctx.textAlign = 'center';
//                    ctx.textBaseline = 'middle';
//                    ctx.fillText(text, width / 2, height / 2);
//
//                    ctx.restore();
//                }
//            }
//        ]
//    });
//
//JS;
//
//$this->registerJs($js);
//?>