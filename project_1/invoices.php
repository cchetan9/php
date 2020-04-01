<?php
include("connection.php");
	ob_start();

	$startdate=$_GET["startdate"];

	$enddate=$_GET["enddate"];

	if($startdate=="")

	{

		$startdate="2014-09-09";

	}

	if($enddate=="")

	{

		$enddate=Date("Y-m-d");

	}

	$paymentstatus=$_GET["paymentstatus"];

	$customertype=$_GET["customertype"];

	$leadsource=$_GET["leadsource"];

	$industry=$_GET["industry"];

	$invoicen=$_GET["invoicen"];

	$amountf=$_GET['amountf'];

	$amountt=$_GET['amountt'];

	$pn=$_GET["page"];
	$rating=$_REQUEST["rating"];

	$nofrow=$_GET["nofrow"];

	if($nofrow=="")

	{

		$nofrow=25;

	}

	$s=$_GET["s"];

	$o=$_GET["o"];

	if($o=="")

	{

		$o=1;

	}
	
	if(isset($_POST["action_type_term"]))
	{
		$term_data=$_POST["term_data"];
		$orderid_data=$_POST["orderid"];
		$data_array['error']=1;
		$data_array['msg']='something goes wrong';
		if($orderid_data!=0 and trim($orderid_data)!='')
		{
			$upd_query="UPDATE orders SET terms =$term_data where orderid=$orderid_data";

	
		$data_array['msg']='';
		if(mysqli_query($conn,$upd_query))
		{
			 $updated=mysqli_query($conn,"select * from orders where orderid=$orderid_data");
			 $row_updated = mysqli_fetch_array($updated);

			 $date=explode(" ",$row_updated['invoiceDate']);

			 list($y1,$m1,$d1)=explode("-",$date[0]);

			 $final_date = $d1."-".$m1."-".$y1;
			 
			 $terms =$term_data;
			 
			 
			 	if($terms<=30)
				{
				$datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+1 months");
				$duedate = date('25-m-Y',$datemonth);
				//~ die;
				}
				elseif($terms<=60)
				{

				$datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+2 months");
				$duedate = date('25-m-Y',$datemonth);

				}
				else
				{

				$datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+3 months");
				$duedate = date('25-m-Y',$datemonth);
				}

					 //~ $datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+".$terms."days");
					 
					 
					 

					 //~ $duedate = date('d-m-Y',$datemonth);



			//$terms = $row_updated['terms'];
			
			//$data_array['res']=$upd_query1;
			$data_array['duedate']=$duedate;
			$data_array['error']=0;
			$data_array['msg']='update successfully';
			
		}
		else
		{
			
			$data_array['msg']='something goes wrong';
		}
			
		}
		
		echo json_encode($data_array);die;
		//~ echo"<pre>";print_r($upd_query);die;
		
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Invoices</title>

<?php

	include("top.php");

?>

 <script>

		$(function() {

			$(".nav ul:nth-child(1)").removeClass("select").addClass("current");

		});


		function search1()

		{

			var startdate=document.getElementById("startdate").value;

			var enddate=document.getElementById("enddate").value;

			var paymentstatus=document.getElementById("paymentstatus").value;

			var customertype=document.getElementById("customertype").value;

			var leadsource=document.getElementById("leadsource").value;

			var industry=document.getElementById("industry").value;

			var rating=document.getElementById("rating").value;

			var invoicen=document.getElementById("invoicen").value;

			var amountf=document.getElementById("amountf").value;

			var amountt=document.getElementById("amountt").value;

			window.location.href="invoices.php?page=1&startdate="+startdate+"&enddate="+enddate+"&paymentstatus="+paymentstatus+"&customertype="+customertype+"&leadsource="+leadsource+"&industry="+industry+"&rating="+rating+"&invoicen="+invoicen+"&amountf="+amountf+"&amountt="+amountt+"&nofrow="+nofrow;


			var nofrow=document.getElementById("nofrow").value;

			if(nofrow!="")

			{

				window.location.href="invoices.php?page=<?=$pn?>&startdate="+startdate+"&enddate="+enddate+"&paymentstatus="+paymentstatus+"&customertype="+customertype+"&leadsource="+leadsource+"&industry="+industry+"&rating="+rating+"&invoicen="+invoicen+"&amountf="+amountf+"&amountt="+amountt+"&nofrow="+nofrow+"&s=<?=$s?>&o=<?=$o?>";

			}



		}


		function checkuncheck(source)
		{
			  checkboxes = document.getElementsByName('c[]');
			  for(var i=0, n=checkboxes.length;i<n;i++)
			  {
					checkboxes[i].checked = source.checked;
			  }
		}



		$(document).keypress(function(e) {
    if(e.which == 13) {

        search1();

    }
});


 </script>
 <style>
	 .terms_update_show input {
    width: 48px;
    height: 26px;
    border-radius: 12px;
    text-align: center;
}
 </style>

<style>
.loader{
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('//upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Phi_fenomeni.gif/50px-Phi_fenomeni.gif') 
              50% 50% no-repeat;
}
</style>

</head>

<?php

	include("header.php");

?>

<!-- start content-outer ........................................................................................................................START -->

<div id="content-outer">

<!-- start content -->

<div id="content">
<div class="loader" style="display: none;"></div>
	<!--  start page-heading -->

	<div id="page-heading">

		<h1>Invoices</h1>

	</div>

	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">

	<tr>

		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>

		<th class="topleft"></th>

		<td id="tbl-border-top">&nbsp;</td>

		<th class="topright"></th>

		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>

	</tr>

	<tr>

		<td id="tbl-border-left"></td>

		<td>

		<!--  start content-table-inner ...................................................................... START -->

		<div id="content-table-inner">

			<!--  start table-content  -->

			<div id="table-content">			

				<!--  start product-table ..................................................................................... -->

				<form id="mainform" name="mainform" method="post" action=""  >

                <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>

                        <th valign="top">Start Date:</th>

                        <td> <input type="text" id="startdate" name="startdate" class="inp-form" value="<?=$startdate ?>"  /></td>

                        </tr>

                        <tr>

                         <th valign="top">End Date:</th>

                            <td> <input type="text" name="enddate" id="enddate" value="<?=$enddate ?>" class="inp-form"   /> </td>             	 </tr>

 					<tr>

                         <th valign="top">Invoice Number:</th>

                        <td> <input   type="text" name="invoicen" id="invoicen" value="<?=$invoicen ?>" class="inp-form"   /> </td>             	 </tr>

                    <tr>

					<tr>

                         <th valign="top">Amount:</th>

                        <td> <input type="text" name="amountf" id="amountf" placeholder="Amount From" value="<?=$amountf ?>" class="inp-form"   />  <input type="text" name="amountt" placeholder="Amount To" id="amountt" value="<?=$amountt ?>" class="inp-form"   /> </td>             	 </tr>

                    <tr>

                        <th valign="top">Payment Status:</th>

                            <td>

                                <select id="paymentstatus" name="paymentstatus" class="styledselect-day styledselect_form_1">

                                	<?php

									if($paymentstatus!="")

									{

										?>

											<option value="<?=$paymentstatus?>" selected="selected"><?php

											if($paymentstatus==0)

											 	{ echo "Paid"; }

											 else

												 { echo "Unpaid"; }

											  ?></option>

                                               <option value="">All</option>

										<?php

									}

									else

									{

								?>

                                	<option value="" selected="selected">All</option>

                                    <?php

									}

									?>

                                    <option value="0">Paid</option>

                                    <option value="2">Unpaid</option>

                                </select>

                             </td>

                        <td></td>

                    </tr>

                      <tr>

                        <th valign="top">Customer Type:</th>

                            <td>

                                <select id="customertype" name="customertype" class="styledselect_form_1">

                                    <?php

									if($customertype!="")

									{

										?>

											<option value="<?=$customertype; ?>" selected="selected"><?=$customertype; ?></option>

                                             <option value="">All</option>

									<?php

									}

									else

									{

								?>

                                	<option value="" selected="selected">All</option>

                                    <?php

									}

									?>


                                    <option value="Docpods">Docpods</option>

                                    <option value="Other">Other</option>

                                    <option value="Podiatrist">Podiatrist</option>

                                    <option value="Retail Customer">Retail Customer</option>

                                    <option value="RSG">RSG</option>

                                    <option value="TAF">TAF</option>



                                </select>

                             </td>

                    </tr>

                     <tr>

                        <th valign="top">Lead Source:</th>

                            <td>

                                <select id="leadsource" name="leadsource" class="styledselect-day styledselect_form_1">

                                	 <?php

									if($leadsource!="")

									{

										?>

											<option value="<?=$leadsource?>" selected="selected"><?=$leadsource ?></option>

                                             <option value="">All</option>

										<?php

									}

									else

									{

								?>

                                	<option value="" selected="selected">All</option>

                                    <?php

									}

									?>

                                    <option value="Act">Act</option>

                                    <option value="Eddie">Eddie</option>

                                    <option value="Mel WA">WA</option>

                                    <option value="Nsw">Nsw</option>

                                    <option value="Nt">Nt</option>

                                    <option value="Other">Other</option>

                                    <option value="Qld">Qld</option>

                                    <option value="Sa">Sa</option>
                                    <option value="Tas">Tas</option>

                                    <option value="Vic">Vic</option>



                                </select>

                             </td>

                    </tr>

                     <tr>

                        <th valign="top">Industry:</th>

                            <td>

                                <select id="industry" name="industry" class="styledselect-day styledselect_form_1">

                                	 <?php

									if($industry!="")

									{

										?>

											<option value="<?=$industry?>" selected="selected"><?=$industry?></option>

                                             <option value="">All</option>

										<?php

									}

									else

									{

								?>

                                	<option value="" selected="selected">All</option>

                                    <?php

									}

									?>

                                    <option value="Advertising">Advertising</option>

                                    <option value="Aerospace & Defence">Aerospace & Defence</option>

                                    <option value="Airlines">Airlines</option>

                                    <option value="Automotive">Automotive</option>

                                    <option value="Banking">Banking</option>

                                    <option value="Biotechnology">Biotechnology</option>

                                    <option value="Business Services">Business Services</option>

                                    <option value="Communications">Communications</option>

                                    <option value="Computer Peripherals">Computer Peripherals</option>

                                    <option value="Electric Utilities">Electric Utilities</option>

                                    <option value="Electronic">Electronic</option>

                                    <option value="Financial Services">Financial Services</option>

                                    <option value="Government">Government</option>

                                    <option value="Healthcare Facilities">Healthcare Facilities</option>

                                    <option value="Insurance">Insurance</option>

                                    <option value="Manufacturing">Manufacturing</option>

                                    <option value="Metal Mining">Metal Mining</option>

                                    <option value="Oil & Gas Operations">Oil & Gas Operations</option>

                                    <option value="Other">Other</option>

                                    <option value="Personal & Household Products">Personal & Household Products</option>

                                    <option value="Personal Services">Personal Services</option>

                                    <option value="Pharmaceutical">Pharmaceutical</option>

                                    <option value="Photography">Photography</option>

                                    <option value="Retail">Retail</option>

                                    <option value="Taf">Taf</option>

                                    <option value="Tobacco">Tobacco</option>

                                    <option value="Water Utilities">Water Utilities</option>

                                </select>

                             </td>

                    </tr>

                    <tr>

                        <th valign="top">Rating:</th>

                            <td>

                                <select id="rating" name="rating" class="styledselect-day styledselect_form_1">

                                	 <?php

									if($rating!="")

									{

										?>

											<option value="<?=$rating?>" selected="selected"><?=$rating?></option>

                                             <option value="">All</option>

										<?php

									}

									else

									{

								?>

                                	<option value="" selected="selected">All</option>

                                    <?php

									}

									?>



                                    <option value="Suttonentities">Bankstown Galleries Pagewood</option>
                                    <option value="Suttonentities">Suttonentities</option>

                                    <option value="Maroochy and Kawana">Maroochy and Kawana</option>
                                    <option value="Tickle Group">Tickle Group</option>
                                    <option value="Warm">Warm</option>
                                    <option value="HO">HO</option>

                                    </select>

                             </td>

                    </tr>

                    <tr>

                    <td valign="top">

                   		<input type="submit" id="search" name="search" value="Search" class="btn" />
                   		<input type="submit" id="search" name="search" value="Search" class="btn" />
<!--
                   		 onClick="return search1(this)" />
-->

                    </td>

                    </tr>

                </table>

<?php

	$searchquery="select (o.totalOrderAmount - sum(p.amount)) as payment, c.*, o.* from orders as o inner join customers as c on o.customerid=c.customerid  left join payment as p on p.orderid=o.orderid where 1 and status != 'on-hold' and status != 'cancelled'";

	$outstanding=$searchquery;
    //echo"<pre>";print_r($outstanding);die;
	
	if(isset($_REQUEST["search"]))

	{

		 $startdate= $_REQUEST["startdate"];

		 $enddate=$_REQUEST["enddate"];

		 $paymentstatus=$_REQUEST["paymentstatus"];

		 $customertype=$_REQUEST["customertype"];

		 $leadsource=$_REQUEST["leadsource"];

		 $industry=$_REQUEST["industry"];

		 $rating=$_REQUEST["rating"];

		 $invoicen=$_REQUEST["invoicen"];

		 $amountf=$_REQUEST["amountf"];

		 $amountt=$_REQUEST["amountt"];

	}

		if($startdate!="" && $enddate!="")

		{

			$searchquery.=" and o.invoiceDate between '$startdate' and '$enddate'";

			$outstanding.=$searchquery;

		}



		if($customertype!="")

		{

			$searchquery.=" and c.customertype='$customertype'";

		}

		if($leadsource!="")

		{

			$searchquery.=" and c.leadsource='$leadsource'";

		}

		if($industry!="")

		{

			$searchquery.=" and c.industry='$industry'";

		}

		if($rating!="")

		{

			$searchquery.=" and c.rating='$rating'";

		}

		if($invoicen!="")

		{

			$searchquery.=" and o.invoiceNumber='$invoicen'";

		}



		if($amountf!="" and $amountt!="")

		{

			$searchquery.=" and o.totalOrderAmount between $amountf and $amountt";
		}

		if($amountf!="")

		{

			$searchquery.=" and o.totalOrderAmount >= $amountf ";
		}

		if($amountt!="")

		{

			$searchquery.=" and o.totalOrderAmount <= $amountt";
		}

	 	$searchquery.=" group by o.orderid";

		if($paymentstatus!="")

		{

			if($paymentstatus==2)

			{

				$searchquery.=" having (o.paymentStatusID=0 and payment>1) or o.paymentStatusID in ('',2) and  totalOrderAmount>=1 ";

			}

			else

			{

				$searchquery.=" having o.paymentStatusID=$paymentstatus and o.paymentStatusID!='' and totalOrderAmount>=0 ";

			}

		}


		if($s!="")

		{

			if($s=="totalOrderAmount")

			{

				$searchquery.=" order by convert($s, decimal)";

				$outstanding.=$searchquery;

			}

			elseif($s=="orderid")

			{

				$searchquery.=" order by o.$s";

			}
			else
			{
				$searchquery.=" order by $s";
			}

			if($o==1)

			{

				$searchquery.=" asc";
				$o=2;
			}

			else

			{

				$searchquery.=" desc";
				$o=1;
			}

		}

		//$searchquery .= ' and ((totalOrderAmount-payment)>1)';

	    $q=$searchquery;
	    //echo "<pre>";print_r($q);
        //  die;

		$csvinvoices1=$searchquery;

		$csvinvoices=mysqli_query($conn,$csvinvoices1);

		$printq=$searchquery;

		$print=mysqli_query($conn,$printq);

        $ros=mysqli_query($conn,$q) or die(mysqli_error());

        $row=mysqli_fetch_array($ros);
        // echo "<pre>we";print_r($row);
        //  die;
        $total=mysqli_num_rows($ros);

        $dis=$nofrow;

        $tp=ceil($total/$dis);

        $pn=(isset($_GET['page']))?$_GET['page']:1;

		if(!isset($_GET['page']))

		{

			echo "<script>window.location.href='invoices.php?page=1'</script>";

		}

        $k=($pn-1)*$dis;


		 $q.=" limit $k,$dis";

    
	$orders=mysqli_query($conn,$q);
	
	

	?>

				<form method="post" name="f1" id="f1" action="invoicedetail.php">
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">

				<tr>

					<th class="table-header-repeat "> <input type="checkbox" name="ac" id="ac"  onClick="checkuncheck(this)" > </th>

					<th class="table-header-repeat line-left"  width="79px"> <a href="invoices.php?page=<?=$pn; ?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>&paymentstatus=<?=$paymentstatus?>&customertype=<?=$customertype?>&leadsource=<?=$leadsource?>&industry=<?=$industry?>&rating=<?=$rating?>&invoicen=<?=$invoicen?>&amountf=<?=$amountf?>&amountt=<?=$amountt?>&nofrow=<?=$nofrow?>&s=invoiceDate&o=<?=$o?>" > Date </a>	</th>

					<th class="table-header-repeat line-left"  width="34px"> <a href="invoices.php?page=<?=$pn; ?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>&paymentstatus=<?=$paymentstatus?>&customertype=<?=$customertype?>&leadsource=<?=$leadsource?>&industry=<?=$industry?>&rating=<?=$rating?>&invoicen=<?=$invoicen?>&amountf=<?=$amountf?>&amountt=<?=$amountt?>&nofrow=<?=$nofrow?>&s=invoiceNumber&o=<?=$o?>" > Invoice </a> </th>

					<th class="table-header-repeat line-left" width="88px"> <a href="invoices.php?page=<?=$pn; ?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>&paymentstatus=<?=$paymentstatus?>&customertype=<?=$customertype?>&leadsource=<?=$leadsource?>&industry=<?=$industry?>&rating=<?=$rating?>&invoicen=<?=$invoicen?>&amountf=<?=$amountf?>&amountt=<?=$amountt?>&nofrow=<?=$nofrow?>&s=orderid&o=<?=$o?>" > Order Id </a> </th>

					<th class="table-header-repeat line-left" width="141px"> <a href="invoices.php?page=<?=$pn; ?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>&paymentstatus=<?=$paymentstatus?>&customertype=<?=$customertype?>&leadsource=<?=$leadsource?>&industry=<?=$industry?>&rating=<?=$rating?>&invoicen=<?=$invoicen?>&amountf=<?=$amountf?>&amountt=<?=$amountt?>&nofrow=<?=$nofrow?>&s=companyname&o=<?=$o?>" > Company Name </a></th>

					<th class="table-header-repeat line-left" width="143px"> <a href="invoices.php?page=<?=$pn; ?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>&paymentstatus=<?=$paymentstatus?>&customertype=<?=$customertype?>&leadsource=<?=$leadsource?>&industry=<?=$industry?>&rating=<?=$rating?>&invoicen=<?=$invoicen?>&amountf=<?=$amountf?>&amountt=<?=$amountt?>&nofrow=<?=$nofrow?>&s=name&o=<?=$o?>" > Customer Name </a> </th>

                    <th class="table-header-repeat line-left"> <a href="invoices.php?page=<?=$pn; ?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>&paymentstatus=<?=$paymentstatus?>&customertype=<?=$customertype?>&leadsource=<?=$leadsource?>&industry=<?=$industry?>&rating=<?=$rating?>&invoicen=<?=$invoicen?>&amountf=<?=$amountf?>&amountt=<?=$amountt?>&nofrow=<?=$nofrow?>&s=totalOrderAmount&o=<?=$o?>" > Amount </a> </th>

                    <th class="table-header-repeat line-left">  Outstanding </th>
                    <th class="table-header-repeat line-left">  Terms </th>

                    <th class="table-header-repeat line-left" width="77px">Due Date</th>
                    <th class="table-header-repeat line-left" width="77px">Payment Date</th>

                    <th class="table-header-repeat line-left" width="137px"> <a href="invoices.php?page=<?=$pn; ?>&startdate=<?=$startdate?>&enddate=<?=$enddate?>&paymentstatus=<?=$paymentstatus?>&customertype=<?=$customertype?>&leadsource=<?=$leadsource?>&industry=<?=$industry?>&rating=<?=$rating?>&invoicen=<?=$invoicen?>&amountf=<?=$amountf?>&amountt=<?=$amountt?>&nofrow=<?=$nofrow?>&s=customertype&o=<?=$o?>" > Customer Type </a> </th>
                    <th class="table-header-repeat line-left">Update  Order Detail</th>
                    <th class="table-header-repeat line-left">View Order Detail</th>
                    <th class="table-header-repeat line-left">Action </th>

				</tr>

			<?php 	while($order=mysqli_fetch_array($orders))

					{

					$id=$order['orderid'];

					$amountqc=mysqli_query($conn,"select amount from payment where orderid=$id and paymentMethodTypeID=9");
					$rowc = mysqli_fetch_array($amountqc);
					$credits=$rowc["amount"];
                    // echo "credit : ";print_r($credits);
					$amountq=mysqli_query($conn,"select sum(amount) as amount,paymentDate from payment where orderid=$id");
					$row = mysqli_fetch_array($amountq);
					$amount=$row["amount"];
					
					$paymentDate=$row["paymentDate"];
					
					$paymentDate = strtotime(date("Y-m-d", strtotime($paymentDate)));

					$paymentDate = date('d-m-Y',$paymentDate);
					//print_r($paymentDate);
					
					

					//$amount=$order["totalOrderAmount"];
					//~ echo "<br>";
					//~ echo "totalOrderAmount=".$order['totalOrderAmount'];
					//~ echo "<br>";
					//~ echo "amount=".$amount;

					$discountRate=$order["discountRate"];
					
					// echo "<br> amount : ".$amount;
					// echo "<br> toal amount : ".$order['totalOrderAmount'];
				   // print_r($amount);
					$outstand=round($order['totalOrderAmount']-$amount,2);
					
					if($outstand>0)
					{
						$outstand=$outstand-$discountRate;
					}
					//echo "outstand".$outstand;die;
					if($amount=="" or $amount==0)
					{	$amount=$row["amount"]; 	
			        }

					$date=explode(" ",$order['invoiceDate']);

					list($y1,$m1,$d1)=explode("-",$date[0]);

					$final_date = $d1."-".$m1."-".$y1;
					
					$terms = $order["terms"];

							//~ $datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+".$terms."days");

							//~ $duedate = date('d-m-Y',$datemonth);
							
							
							//~ echo 	$final_date;die;
	
				if($terms<=30)
				{
					//~ echo"if";
				 $datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+1 months");
				 //~ echo 	date('d-m-Y',$datemonth);
				 $duedate = date('25-m-Y',$datemonth);
				//~ die;
				}
				elseif($terms<=60)
				{
					//~ echo"else if";

				 $datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+2 months");
				
				 $duedate = date('25-m-Y',$datemonth);

				}
				else
				{
					//~ echo"else ";

				//$datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+90 days");

			     //+3 months(90 Day).		
				 $datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+3 months");
				 $duedate = date('25-m-Y',$datemonth);
				}


			

					// if($d1 >= 20)

					// {

					// 	if($d1 >= 29 ){


					// 		$datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+50 days");

					// 		$duedate = date('25-m-Y',$datemonth);


					// 	}else{

					// 		$datemonth = strtotime(date("d-m-Y", strtotime($final_date)) . "+2 month");

					// 		$duedate = date('25-m-Y',$datemonth);

					// 	}

					// }

					// else

					// {

					// 	$datemonth = strtotime(date("Y-m-d", strtotime($order['invoiceDate'])) . "+1 month");

					// 	$duedate = date('25-m-Y',$datemonth);

					// }
					if($order["paymentStatusID"] == '0')
					{
                      $final_outstanding_amount = 0;
					}else{
						//For outstanding amount
						if($order['totalOrderAmount']=="" ) {
							$final_outstanding_amount = "no amount"; 
						} else if($amount=="") {
							$final_outstanding_amount = round($order['totalOrderAmount']-round($credits,2),2); 
							//print_r($final_outstanding_amount);
						} else if($outstand>1) {
							$final_outstanding_amount = round($outstand,2); 
						} else if($order["paymentStatusID"]=="" || $order["paymentStatusID"]==2 || $order["paymentStatusID"]==3) { 
							$final_outstanding_amount = round($amount-$credits,2); 
						}  else  if($outstand=="") {
							$final_outstanding_amount = round($amount-$row['amount'],2); 
						} else {
							$final_outstanding_amount = round($outstand,2); 
						}
					}

                    //echo "<pre>";echo $id.":".$final_outstanding_amount;

					?>

					<tr>
                                <td> <input type="hidden" name="o[]" id="o" value="<?=$order['orderid']; ?> ">  </td>
								<td> <input type="checkbox" name="c[]" id="c" value="<?=$order['orderid']; ?> ">  </td>

								<td> <?=date("d-m-Y",strtotime($order['invoiceDate'])) ?></td>

								<td> <?=$order['invoiceNumber']; ?></td>

								<td> <?=$order['orderid']; ?></td>

								<td>  <?php if($order['companyname']=="") { echo "no Relationship"; } else { echo $order['companyname']; } ?> </td>

								<td>  <?=$order['name']; ?></td>

								<td> <?php if($order['totalOrderAmount']=="") { echo "no amount"; } else { echo round($order['totalOrderAmount'],2); } ?></td>

								 <td> <?php echo $final_outstanding_amount; ?></td>
								 	<td> 
							    <div class="terms_edit_show <?php echo "term_".$order['orderid']; ?>" >  <?=$order['terms']; ?></div>
								<div class="terms_update_show <?php echo "terms_update_show_".$order['orderid']; ?> " style=" display: none; "> 
								 <input type="text" class="<?php echo "term_upd_".$order['orderid']; ?> " data-id=" terms "  value="<?=$order['terms']; ?>"><br>
</div>
										
										
										 
								 	
								 	</td>

								<td id="Due_date<?=$order['orderid']; ?>">  <?=$duedate; ?> </td>
								
								 
								 <td>  <?php
								//echo $final_outstanding_amount;
								if($final_outstanding_amount != 0){
									echo '';
								}else{
									echo $paymentDate;
								}
								 ?> </td>

								<td>  <?=$order['customertype']; ?></td>

								<td class="options-width">

								  <div class="update_order_details"  data-id="<?=$order['orderid']?>"  style=" cursor: pointer;  "