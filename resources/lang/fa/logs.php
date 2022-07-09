<?php

return [
    'factor_report' => ' کاربر :userName با آیدی :userId' . "\n"
        . 'با آدرس ' . ':state :city :address' . "\n"
        . 'به نام ' . ':firstName :lastName' . "\n"
        . 'از طریق درگاه' . ':paymentMethod' . "\n"
        . 'در تاریخ ' . ':date' . "\n"
        . 'محصولات فاکتور ' . ':factorId' . "\n"
        .'را خریداری کرد و مبلغ '.':price '.'تومان از کیف پول ایشان کاهش یافت.'
    ,
    'wallet_payment_report'=> ' کاربر :userName با آیدی :userId' . "\n"
        . 'در تاریخ ' . ':date' . "\n"
    .'کیف پول خود را به مبلغ '.':value'."\n"
    .'از طریق درگاه '.':doorway '.'شارژ کرد.'
    ,

    'order_ordered_log'=> ':user سفارش کاربر '."\n" . ':date در تاریخ ' . "\n" . 'ثبت شد.',
    'order_checked_log'=>':user سفارش کاربر '."\n".':date در تاریخ '."\n".'توسط مدیر :admin '."\n".'تایید شد.',
    'order_sent_log'=>':user سفارش کاربر '."\n" . ':date در تاریخ ' . "\n" . 'تحویل اداره پست داده شد.',
    'order_delivered_log'=>':user سفارش کاربر '."\n" . ':date در تاریخ ' . "\n" . 'به آدرس درج شده در فاکتور تحویل داده شد.',
];