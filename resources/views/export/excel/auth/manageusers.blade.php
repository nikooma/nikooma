<?php
use Morilog\Jalali\jDateTime;
use App\Http\Controllers\app_code\GClass;
?>
<html>
        <?php $headerset=0; foreach ($itemlist as $item) { ?>
        <?php if($headerset==0){ ?>
            <thead>
            <tr style="background-color: #ddd9c3;">				
				<?php echo (isset($item->id)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">شماره</th>':""); ?>
				<?php echo (isset($item->name)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">نام</th>':""); ?>
				<?php echo (isset($item->u_lname)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">نام خانوادگی</th>':""); ?>
				<?php echo (isset($item->username)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">نام کاربری</th>':""); ?>
				<?php echo (isset($item->sip_number)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">تلفن سیپ</th>':""); ?>
				<?php echo (isset($item->usercontext)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">سرورتلفنی</th>':""); ?>
				<?php echo (isset($item->u_timeout)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">محلت زمان اتصال</th>':""); ?>
				<?php echo (isset($item->u_rejects)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">تعداد پاسخ داده نشده مجاز</th>':""); ?>
				<?php echo (isset($item->u_wrapuptime)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">زمان تنفس</th>':""); ?>
				<?php echo (isset($item->u_rejecttime)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">تاخیر رد تماس</th>':""); ?>
				<?php echo (isset($item->u_noanswer)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">تاخیر بی پاسخ ماندن تماس</th>':""); ?>
				<?php echo (isset($item->u_dnd)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">تاخیر dnd</th>':""); ?>							
				<?php echo (isset($item->u_mobilenumber)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">تلفن همراه</th>':""); ?>
				<?php echo (isset($item->email)?'<th style="font-size: 16px; font-weight: bold; color: #0033CC;text-align: center">پست الکترونیک</th>':""); ?>		
			</tr>
            </thead>
            <tbody>
            <?php $headerset=1;} ?>
				<tr>					
					<?php echo (isset($item->id)?'<td class="text-center">'.GClass::enTOfa($item->id).'</td>':""); ?>
					<?php echo (isset($item->name)?'<td class="text-center">'.$item->name.'</td>':""); ?>
					<?php echo (isset($item->u_lname)?'<td class="text-center">'.$item->u_lname.'</td>':""); ?>
					<?php echo (isset($item->username)?'<td class="text-center">'.$item->username.'</td>':""); ?>
					<?php echo (isset($item->sip_number)?'<td class="text-center">'.$item->sip_number.'</td>':""); ?>
					<?php echo (isset($item->usercontext)?'<td class="text-center">'.$item->usercontext.'</td>':""); ?>
					<?php echo (isset($item->u_timeout)?'<td class="text-center">'.$item->u_timeout.'</td>':""); ?>
					<?php echo (isset($item->u_rejects)?'<td class="text-center">'.$item->u_rejects.'</td>':""); ?>
					<?php echo (isset($item->u_wrapuptime)?'<td class="text-center">'.$item->u_wrapuptime.'</td>':""); ?>
					<?php echo (isset($item->u_rejecttime)?'<td class="text-center">'.$item->u_rejecttime.'</td>':""); ?>
					<?php echo (isset($item->u_noanswer)?'<td class="text-center">'.$item->u_noanswer.'</td>':""); ?>
					<?php echo (isset($item->u_dnd)?'<td class="text-center">'.$item->u_dnd.'</td>':""); ?>							
					<?php echo (isset($item->u_mobilenumber)?'<td class="text-center">'.$item->u_mobilenumber.'</td>':""); ?>
					<?php echo (isset($item->email)?'<td class="text-center">'.$item->email.'</td>':""); ?>							
				</tr>
            <?php } ?>
        </tbody>
</html>