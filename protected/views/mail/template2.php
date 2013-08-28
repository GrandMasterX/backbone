<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>mail</title>
</head>
<body>
<table height="14px;"></table>
<table align="center" height="57px" width="566" cellpadding="0" cellspacing="0" border="0" background="http://s4.uploads.ru/ZpNCW.png" style="border-collapse: collapse; ">
    <tr>
        <td style="width:24px;"></td>
        <td align="center">
            <p style="color:#959595;line-height: 1;font-size: 14px;font-family: arial, sans-serif;">Вы получили это письмо потому что подписаны на сервис Astrafit в магазине</br>MustHave.ua</p>
        </td>
    </tr>
</table>
<table align="center" width="778" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr style="height:25px;"></tr>
    <tr cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
        <td style="width:47px;">
            <div style="height:459px;background:#FDE034;"></div>
        </td>
        <td style="width:390px;">
            <div style="height:459px;background:#FDE034;">
                <div style="height:85px"></div>
                <img src="http://www.astrafit.com.ua/uploads/email/email2/text.png" border="0" />
            </div>
        </td>
        <td>
            <div style="height:459px;background:#FDE034;">
                <img src="http://www.astrafit.com.ua/uploads/custom/item/galleryImages/<?php echo $item->id?>/<?php if(isset($item->mainItemImage['1']->name)) echo $item->mainItemImage['1']->name;?>" border="0" height="371px" />
            </div>
        </td>
    </tr>
</table>
<table align="center" width="448" height="125" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr style="height:68px"></tr>
    <tr>
        <td>
            <img src="http://www.astrafit.com.ua/uploads/email/email2/text2.png" border="0" />
        </td>
    </tr>
</table>
<!-- *** -->
<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr height="78"></tr>
    <tr>
        <td style="border: 1px solid #D2D2D2;" background="http://www.astrafit.com.ua/uploads/custom/item/galleryImages/<?php echo $evaluated[1]['id'];?>/<?php echo $evaluated[1]['image'];?>" width="276" height="500">
            <table width="276" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
                <tr height="382"></tr>
                <tr height="68" >
                    <td align="center" style="background-color:#FDE034;">
                        <p style="margin:0;text-transform:uppercase;font-size:30px;font-family:arial, sans-serif;font-weight:bold;">Ваш размер  <?php echo $evaluated[1]['sizeFitting'];?></p>
                    </td>
                </tr>
                <tr height="50"></tr>
            </table>
        </td>
        <td width="88"></td>
        <td style="border: 1px solid #D2D2D2;" background="http://www.astrafit.com.ua/uploads/custom/item/galleryImages/<?php echo $evaluated[2]['id'];?>/<?php echo $evaluated[2]['image'];?>" width="276" height="500">
            <table width="276" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
                <tr height="382"></tr>
                <tr height="68" >
                    <td align="center" style="background-color:#FDE034;">
                        <p style="margin:0;text-transform:uppercase;font-size:30px;font-family:arial, sans-serif;font-weight:bold;">Ваш размер  <?php echo $evaluated[2]['sizeFitting'];?></p>
                    </td>
                </tr>
                <tr height="50"></tr>
            </table>
        </td>
    </tr>
</table>
<table align="center" width="480" height="30" cellpadding="0" cellspacing="0" border="0" style="margin-top:-22px; border-collapse: collapse; ">
    <tr height="5"></tr>
    <tr>
        <td ><a href="http://www.astrafit.com.ua/site/result?item_id=<?php echo $evaluated[1]['id']?>&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=picture&utm_campaign=5SaleReminder"><img src="http://www.astrafit.com.ua/uploads/email/email2/button.png" border="0" target="_blank" /></a></td>
        <td width="246" ></td>
        <td><a href="http://www.astrafit.com.ua/site/result?item_id=<?php echo $evaluated[2]['id']?>&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=picture&utm_campaign=5SaleReminder"><img src="http://www.astrafit.com.ua/uploads/email/email2/button.png" border="0" target="_blank" /></a></td>
    </tr>
</table>
<!-- *** -->
<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr height="20"></tr>
    <tr>
        <td style="border: 1px solid #D2D2D2;" background="http://www.astrafit.com.ua/uploads/custom/item/galleryImages/<?php echo $evaluated[3]['id'];?>/<?php echo $evaluated[3]['image'];?>" width="276" height="500">
            <table width="276" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
                <tr height="382"></tr>
                <tr height="68" >
                    <td align="center" style="background-color:#FDE034;">
                        <p style="margin:0;text-transform:uppercase;font-size:30px;font-family:arial, sans-serif;font-weight:bold;">Ваш размер  <?php echo $evaluated[3]['sizeFitting'];?></p>
                    </td>
                </tr>
                <tr height="50"></tr>
            </table>
        </td>
        <td width="88"></td>
        <td style="border: 1px solid #D2D2D2;" background="http://www.astrafit.com.ua/uploads/custom/item/galleryImages/<?php echo $evaluated[4]['id'];?>/<?php echo $evaluated[4]['image'];?>" width="276" height="500">
            <table width="276" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
                <tr height="382"></tr>
                <tr height="68" >
                    <td align="center" style="background-color:#FDE034;">
                        <p style="margin:0;text-transform:uppercase;font-size:30px;font-family:arial, sans-serif;font-weight:bold;">Ваш размер  <?php echo $evaluated[4]['sizeFitting'];?></p>
                    </td>
                </tr>
                <tr height="50"></tr>
            </table>
        </td>
    </tr>
</table>
<table align="center" width="480" height="30" cellpadding="0" cellspacing="0" border="0" style="margin-top:-22px;border-collapse: collapse; ">
    <tr height="5"></tr>
    <tr>
        <td ><a href="http://www.astrafit.com.ua/site/result?item_id=<?php echo $evaluated[3]['id']?>&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=picture&utm_campaign=5SaleReminder"><img src="http://www.astrafit.com.ua/uploads/email/email2/button.png" border="0" target="_blank" /></a></td>
        <td width="246" ></td>
        <td><a href="http://www.astrafit.com.ua/site/result?item_id=<?php echo $evaluated[4]['id']?>&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=picture&utm_campaign=5SaleReminder"><img src="http://www.astrafit.com.ua/uploads/email/email2/button.png" border="0" target="_blank" /></a></td>
    </tr>
</table>
<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr height="20"></tr>
    <tr>
        <td style="border: 1px solid #D2D2D2;" background="http://www.astrafit.com.ua/uploads/custom/item/galleryImages/<?php echo $evaluated[5]['id'];?>/<?php echo $evaluated[5]['image'];?>" width="276" height="500">
            <table width="276" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
                <tr height="382"></tr>
                <tr height="68" >
                    <td align="center" style="background-color:#FDE034;">
                        <p style="margin:0;text-transform:uppercase;font-size:30px;font-family:arial, sans-serif;font-weight:bold;">Ваш размер  <?php echo $evaluated[5]['sizeFitting'];?></p>
                    </td>
                </tr>
                <tr height="50"></tr>
            </table>
        </td>
        <td width="88"></td>
        <td style="border: 1px solid #D2D2D2;" background="http://www.astrafit.com.ua/uploads/custom/item/galleryImages/<?php echo $evaluated[6]['id'];?>/<?php echo $evaluated[6]['image'];?>" width="276" height="500">
            <table width="276" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
                <tr height="382"></tr>
                <tr height="68" >
                    <td align="center" style="background-color:#FDE034;">
                        <p style="margin:0;text-transform:uppercase;font-size:30px;font-family:arial, sans-serif;font-weight:bold;">Ваш размер <?php echo $evaluated[6]['sizeFitting'];?></p>
                    </td>
                </tr>
                <tr height="50"></tr>
            </table>
        </td>
    </tr>
</table>
<table align="center" width="480" height="30" cellpadding="0" cellspacing="0" border="0" style="margin-top:-22px;border-collapse: collapse; ">
    <tr height="5"></tr>
    <tr>
        <td ><a href="http://www.astrafit.com.ua/site/result?item_id=<?php echo $evaluated[5]['id']?>&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=picture&utm_campaign=5SaleReminder"><img src="http://www.astrafit.com.ua/uploads/email/email2/button.png" border="0" target="_blank" /></a></td>
        <td width="246" ></td>
        <td><a href="http://www.astrafit.com.ua/site/result?item_id=<?php echo $evaluated[6]['id']?>&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=picture&utm_campaign=5SaleReminder"><img src="http://www.astrafit.com.ua/uploads/email/email2/button.png" border="0" target="_blank" /></a></td>
    </tr>
</table>

<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr height="40"></tr>
    <tr >
        <td width="268"><img src="http://www.astrafit.com.ua/uploads/email/email2/text3.png" border="0" /></td>
        <td width="94"></td>
        <td>
            <a href="http://www.astrafit.com.ua/site/suitableItems?parent_id=4&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=massSize&utm_campaign=5SaleReminder" target="_blank"><img src="http://www.astrafit.com.ua/uploads/email/email2/picture2.png" border="0" /></a>
        </td>
    </tr>
</table>
<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr height="59"></tr>
    <tr>
        <td><img src="http://www.astrafit.com.ua/uploads/email/email2/pict3.png" border="0" /></td>
        <td style="vertical-align:top" width="198"><p style="margin:0;margin: 0;font-size: 112px;font-weight: bold;font-family: arial,sans-serif; color:#C73F69;"><?php echo $user['promo_code'];?></p></td>
    </tr>
</table>
<table align="center" width="640" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr>
        <td align="center">
            <p style="color:#0068F9;font-weight:bold;font-family: arial;font-size: 27px;line-height: 1.4;"><span style="text-decoration:underline;">до конца акции осталось 3 дня! Успей!</span></br>ЗВОНИ(044)353-00-92</br>или ЗАХОДИ - <a href="http://www.astrafit.com.ua/site/moveon?code=<?php echo $item->code; ?>&item_id=<?php echo $user['last_item_id']?>&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=toShop&utm_campaign=5SaleReminder">www.musthave.ua</a></p>
        </td
    </tr>
</table>
<table align="center" width="530" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr height="5"></tr>
    <tr>
        <td>
            <p style="color:#7F7F7F;font-family:arial, sans-serif;font-size:12px;line-height: 1.2;">*Представитель кода предоставляется единоразовая скидка 5% на платья MustHave</br>Если у вас есть скидочная карточка. тогда скидка сумируется, но не может превышать 10.
                </br></br>Наш адрес: ул. Стретенская 10, г. Киев, Украина.
                </br></br>Скидка действительна до: 09.08.2013 г.</p>
        </td>
    </tr>
</table>
<table align="center" width="530" height="30" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse; ">
    <tr height="19"></tr>
    <tr height="30">
        <td width="180" align="center" height="30" style="border:1px solid #E7E7E7;">
            <a title="" href="http://www.astrafit.com.ua/mailingList/email/unsubscribe?ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=refuse&utm_campaign=5SaleReminder" target="_blank" style="font-family:arial, sans-serif;font-size:14px;text-decoration:underline;margin:0; color:#E7E7E7;">отказаться от рассылки</a>
        </td>
        <td width="10"></td>
        <td width="180" align="center" height="30" style="background:#74A6D1;">
            <a title="" href="http://www.astrafit.com.ua/site/mydata?size=1&ucode=<?php echo $user['email_hash']?>&id=<?php echo $user['id']?>&utm_source=astrafit&utm_medium=email&utm_content=dashboard&utm_campaign=5SaleReminder" target="_blank" style="color:#fff;font-family:arial, sans-serif;font-size:14px;text-decoration:underline;margin:0;">вход в личный кабинет</a>
        </td>
        <td width="160"></td>
    </tr>
</table>
</body>
</html>