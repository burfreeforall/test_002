<?PHP 
	//include fn
	include 'connect_db.php';
	include 'equal_bin.php';
	include 'min_zero_max.php';
	include 'min_max.php'; //abcdefghij

	$disabled1 = '';
	$disabled2 = '';

	if(isset($_REQUEST['keywords'])){
		$keywords = $_REQUEST['keywords'];
		$score = array();
		$title = array();
		$doc_name = array();
		
		
		$looper = array(array('blockquote-success','blockquote-warning','blockquote-danger'),array('Easy','Medium','Hard'));

		if ($keywords == 'dm') {
			$sql_test = "SELECT T2.id_doc_preprocess, title, text_char_limit,total_score FROM doc_preprocess as T2, doc_search_engine as T1, doc_loanword_extr as T3 WHERE T2.id_doc_search_engine = T1.id_doc_search_engine AND T2.id_doc_preprocess = T3.id_doc_preprocess AND T1.id_doc_search_engine BETWEEN 1 AND 10";
			if($disabled2 == 'disabled'){
				$disabled1 = 'disabled';
				$disabled2 = 'disabled';
			}else{
				$disabled1 = 'disabled';
			}
			
	
		}else{
			$sql_test = "SELECT T2.id_doc_preprocess, title, text_char_limit,total_score FROM doc_preprocess as T2, doc_search_engine as T1, doc_loanword_extr as T3 WHERE T2.id_doc_search_engine = T1.id_doc_search_engine AND T2.id_doc_preprocess = T3.id_doc_preprocess AND T1.id_doc_search_engine BETWEEN 12 AND 21";
			$disabled2 = 'disabled';

		}
		
		$query = mysqli_query($conn_db, $sql_test);

		while ($rs = mysqli_fetch_assoc($query)){
			$score[$rs['id_doc_preprocess']] = $rs['total_score'];
			$title[$rs['id_doc_preprocess']] = $rs['title'];
			$doc_name[$rs['id_doc_preprocess']] = $rs['text_char_limit'];
		}

		//การติดต่อฟังก์ชั่น
		//equal bin 
		$techn_A = equal_bin($score, $conn_db);

		//min0 and max
		$techn_B = min_zero_max($score, $conn_db);

		//min and max
		$techn_C = min_max($score, $conn_db);

	} 	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.atr-evaluation.ffa">
	<head>
		<title>Text Readability Evaluation</title>
		<!-- <meta charset="utf-8"> -->
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

		<!-- stylesheest css bootstrap -->
		<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<style type="text/css">
			.snippet {
				 white-space: nowrap;
				 overflow: hidden;
				 text-overflow: ellipsis;
				}
		</style>

		<!-- Javascript -->
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		
	</head>

	<body style="padding-top: 70px">
		
		<!-- Nav bar -->
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container-fluid">
		  	<div class="row">
		  		<div class="col-lg-1"></div>
  				<div class="col-lg-11">
    				<!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand" href="#">Text Readability Assessment</a>
				   	</div>
		   			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		   				<!-- <div class="col-lg-6"> -->
		   					<form class="navbar-form navbar-right" id="textSearch" role="search" name="textSearch" action="ATR_from_2.php" method="POST">
				        		<div class="form-group" >
				        			<!-- <input id="find" type="text" class="form-control" placeholder="Choose keywords"> -->
				        			<label for="keywords" >Select keywords:</label>
									  <select class="form-control" id="keywords" name="keywords">
									    <!-- <option disabled>Disabled</option> -->
									    <!-- <option value="" selected>Select keywords</option> -->
									    <option >Select keywords</option>
									    <option value="dm" id="key_dm"  >Data mining</option>
									    <option value="ios" id="key_iOS" >iOS operating system</option>
									  </select>
				        		</div>
			        			<button type="submit" class="btn btn-default" id="btn_clustering"></span>Clustering</button>

						 		<!-- <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked="checked"> 3 ระดับ  -->
						 		<!-- <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> 5 ระดับ  -->
					
			     			</form>
			     		<!-- </div>  -->
			     	</div>
			    </div>
			</div>
		  </div>
		</nav>
		<!-- End nav bar -->

	<!-- Content -->
	<div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
      	<!-- techique A -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h3>Technique A
          		<small>
	          		<abbr title="Vote">Vote</abbr>
		          	<!-- <label class="radio-inline"> -->
		  				<input type="radio" name="vote1" id="Radio1_A" value="1st"> 1st
				  	<!-- </label> -->
				  	<!-- <label class="radio-inline"> -->
		       			<input type="radio" name="vote2" id="Radio2_A" value="2nd"> 2nd
				  	<!-- </label> -->
				  	<!-- <label class="radio-inline"> -->
		        		<input type="radio" name="vote3" id="Radio3_A" value="3rd"> 3rd
				  	<!-- </label> -->
			  	</small>
          </h3> 
         
          
          <?PHP
          if(isset($techn_A)){
          	for ($i=0; $i < 3; $i++) { 
          		
          ?>
          <!-- Easy -->
          <blockquote class='<?PHP echo $looper[0][$i];?>'>
			  <p><?PHP echo $looper[1][$i];?></p>

			  <?PHP 
			  	if(isset($techn_A[$looper[1][$i]])){
			      foreach ($techn_A[$looper[1][$i]] as $key => $value) {
			          $text = file('doc/doc_limited_char/'.$doc_name[$key]);   //อ่านไฟล์เอกสารจากโฟลเดอร์
			          $string_doc = '';
			          foreach($text as $index=>$value_string){
			            $string_doc.= $value_string;                    //ต่อ str เพื่อนับอักขระ 
			          }?>
			        
			          <footer>
			          	<cite title="Source Title">
			          		<input type='hidden' id='hidden<?PHP echo $key;?>' value='<?PHP echo $string_doc;?>'>
			          		<a href="#" onclick="return modalform($('#hidden<?PHP echo $key;?>').val());">
			          			<p class="snippet"><?PHP echo $title[$key];?></p><!-- <br> -->
			          		</a>
			          	</cite>
			          </footer>
			  <?php 
				  }
			   }
			  ?>

		  </blockquote>
		  <!-- /.Easy -->
          <?PHP				
          	}
          }
          ?>
          
        </div>
        <!-- /.techique A -->

        <!-- techique B -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h3>Technique B 
	          	<small>
	          		<abbr title="Vote">Vote</abbr>
		          	<!-- <label class="radio-inline"> -->
		  				<input type="radio" name="vote1" id="Radio1_B" value="1st"> 1st
				  	<!-- </label> -->
				  	<!-- <label class="radio-inline"> -->
		       			<input type="radio" name="vote2" id="Radio2_B" value="2nd"> 2nd
				  	<!-- </label> -->
				  	<!-- <label class="radio-inline"> -->
		        		<input type="radio" name="vote3" id="Radio3_B" value="3rd"> 3rd
				  	<!-- </label> -->
			  	</small>
		  </h3>
	          <?PHP
          if(isset($techn_B)){
          	for ($i=0; $i < 3; $i++) { 
          		
          ?>
          <!-- Easy -->
          <blockquote class='<?PHP echo $looper[0][$i];?>'>
			  <p><?PHP echo $looper[1][$i];?></p>

			  <?PHP 
			  	if(isset($techn_B[$looper[1][$i]])){
			      foreach ($techn_B[$looper[1][$i]] as $key => $value) {
			          $text = file('doc/doc_limited_char/'.$doc_name[$key]);   //อ่านไฟล์เอกสารจากโฟลเดอร์
			          $string_doc = '';
			          foreach($text as $index=>$value_string){
			            $string_doc.= $value_string;                    //ต่อ str เพื่อนับอักขระ 
			          }
			   ?>
			        
			          <footer>
			          	<cite title="Source Title">
			          		<input type='hidden' id='hidden<?PHP echo $key;?>' value='<?PHP echo $string_doc;?>'>
			          		<a href="#" onclick="return modalform($('#hidden<?PHP echo $key;?>').val());">
			          			<p class="snippet"><?PHP echo $title[$key];?></p><!-- <br> -->
			          		</a>
			          	</cite>
			          </footer>
			  <?php 
				  }
			    }
			  ?>

		  </blockquote>
		  <!-- /.Easy -->
          <?PHP				
          	}
          }
          ?>
        </div>
        <!-- /.techique B -->

        <!-- techique C -->
        <div class="col-lg-4">
          <img class="img-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
          <h3>Technique C
          		<small>
	          		<abbr title="เลือกอันดับเทคนิคที่มีความใกล้เคียงกับตนเองมากที่สุด">Vote</abbr>
		          	<!-- <label class="radio-inline"> -->
		  				<input type="radio" name="vote1" id="Radio1_C" value="1st"> 1st
				  	<!-- </label> -->
				  	<!-- <label class="radio-inline"> -->
		       			<input type="radio" name="vote2" id="Radio2_C" value="2nd"> 2nd
				  	<!-- </label> -->
				  	<!-- <label class="radio-inline"> -->
		        		<input type="radio" name="vote3" id="Radio3_C" value="3rd"> 3rd
				  	<!-- </label> -->
			  	</small>
          </h3>
          	

           <?PHP
          if(isset($techn_C)){
          	for ($i=0; $i < 3; $i++) { 
          		
          ?>
          <!-- Easy -->
          <blockquote class='<?PHP echo $looper[0][$i];?>'>
			  <p><?PHP echo $looper[1][$i];?></p>

			  <?PHP 
			  	if(isset($techn_A[$looper[1][$i]])){
			      foreach ($techn_C[$looper[1][$i]] as $key => $value) {
			          $text = file('doc/doc_limited_char/'.$doc_name[$key]);   //อ่านไฟล์เอกสารจากโฟลเดอร์
			          $string_doc = '';
			          foreach($text as $index=>$value_string){
			            $string_doc.= $value_string;                    //ต่อ str เพื่อนับอักขระ 
			          }?>
			        
			          <footer>
			          	<cite title="Source Title">
			          		<input type='hidden' id='hidden<?PHP echo $key;?>' value='<?PHP echo $string_doc;?>'>
			          		<a href="#" onclick="return modalform($('#hidden<?PHP echo $key;?>').val());">
			          			<p class="snippet"><?PHP echo $title[$key];?></p><!-- <br> -->
			          		</a>
			          	</cite>
			          </footer>
			  <?php 
				  }
			    }
			  ?>

		  </blockquote>
		  <!-- /.Easy -->
          <?PHP				
          	}
          }
          ?>
        </div>
        <!-- /.techique C -->
      </div><!-- /.row -->

      <hr class="featurette-divider">

      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p> Powered by Mr.Burhan Wanglem. © 2017 · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
      </footer>

    </div>
	
	 <!-- Modal -->
	  <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      <div class="modal-dialog modal-lg" role="document">
	          <div class="modal-content">
	              <div class="modal-header">
	                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                  <h4 class="modal-title">Document</h4>
	              </div>
	              <div class="modal-body">
	                  <p> <!-- Content --> </p>
	              </div>
	          </div>
	      </div>
	  </div>
	  <!-- /.Modal -->

	  <!-- Javascript -->
	  <script>

	  		$('form').submit(function() {
			  $(this).find("select[name='keywords']").prop('disabled',true);
			});

			function modalform(string) {
			    // console.log(string);
			    $('#myModal').modal({backdrop: 'static', keyboard: false});  //set ให้คลิกปุ่มปิดเพื่อปิดได้อย่างเดียว
			    $('#myModal').modal('show');
			    $('#myModal p').attr('str', string);
			    $('#myModal p').text(string);
			}

			// $("#textSearch").on("change click", function(e) {
			// 	$("#textSearch").saveForm();
			// });




			$('#myModal button').click(function () {
			    $('#myModal p').removeAttr('str');
			});

			// $('#textSearch').on('submit', function() {
			//     $('#keywords').prop('disabled', true);
			// });

			// $('#textSearch').submit(function(event){
			// 	$('form[name=textSearch]').setAttrib('action','ATR_from_2.php');
			// 	var value = $('#keywords option:selected').val();
			// 	console.log(value);
			// 	// $('#keywords option:selected').attr('disabled','disabled');
			// });
			// $('#keywords').change(function(){
			//     // var key = this.value;
			// 	$("#keywords option:selected").attr('disabled','disabled');
			// });

	  </script>
  	  <!-- /.Javascript -->

	</body>
</html>
