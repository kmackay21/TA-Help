<?php
session_start();
include 'config.php';
if(!isset($_SESSION['username']))
{
    header('location:index.php');
    exit();
}
?>
<?php
log_time();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

    <title>Student Help Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!---CSS FILES -->

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/Login.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/custom.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/student.css" type="text/css" />
    <!---END OF CSS FILES -->

    <SCRIPT language=JavaScript>
        function getTimeStamp()
        {
            var now = new Date();
            return ((now.getMonth() + 1) + '/' + (now.getDate()) + '/' + now.getFullYear() + " " + now.getHours() + ':' +
            ((now.getMinutes() < 10) ? ("0" + now.getMinutes()) : (now.getMinutes())) + ':' + ((now.getSeconds() < 10) ?
                ("0" + now.getSeconds()) : (now.getSeconds())));
        }
        function reload(form)
        {
            var val=form.cat.options[form.cat.options.selectedIndex].value;
            self.location='dashboard.php?cat=' + val ;
        }
    </script>
</head>

<body>

<div id="dashboard-container">
    <p>
        <?php echo "<h4>Welcome</h4> <h2>".$_SESSION['username']."</h2>"; ?>
        <a href="logout.php" id="login-btn" class="btn btn-primary">Logout</a>
    </p>

    <div id="login">
        <h3>Student Help Page</h3>
        <div id="error" >

        </div>

        <!-- --------Student Help Form ----- -->
        <form id="login-form" action="" class="form">
            <form id="form" class="login-form" method="post" enctype="application/x-www-form-urlencoded" accept-charset="UTF-8">
                <p></p>
                <div class="content">
                    <div id="section0" >
                        <div class="field"><label for="colemanid">ColemanID</label><input type="text" id="colemanid" name="colemanid" placeholder="ColemanID : <?php echo $_SESSION['colemanid']?>" readonly></div>
                        <div class="field"><label for="username">Username</label><input type="text" id="username" name="username" placeholder="Username : <?php echo $_SESSION['username']?>" readonly></div>
                        <div class="field"><label for="email">Email</label><input type="text" id="email" name="email" placeholder="Email : <?php echo $_SESSION['email']?>" readonly></div>
                        <div class="field"><label for="phonenum">Cell Number</label><input type="text" id="phonenum" name="phonenum" placeholder="Cell Number : <?php echo $_SESSION['phonenum']?>" readonly></div>

                        <?php
                        @$cat=$_GET['cat'];
                        if(strlen($cat) > 0 and !is_numeric($cat)){ // to check if $cat is numeric data or not.
                            echo "Data Error";
                            exit;
                        }
                        $quer2="SELECT DISTINCT category,cat_id FROM category ORDER BY 'SD','GDD','NS','GD','GEN ED'";
                        //End of query for first list box
                        //for second drop down list we will check if category is selected else we will display all the subcategory
                        if(isset($cat) and strlen($cat) > 0){
                            $quer="SELECT DISTINCT subcategory FROM subcategory where cat_id=$cat order by subcategory";
                        }else{$quer="SELECT DISTINCT subcategory FROM subcategory order by 'SD TA_1','SD TA_2','SD TA_3','SD TA_4','GDD TA_1','GDD TA_2','GDD TA_3','GDD TA_4','NS TA_1','NS TA_2',
								'NS TA_3','NS TA_4','GD TA_1','GD TA_2','GD TA_3','GD TA_4','GEN ED_1','GEN ED_2','GEN ED_3','GEN ED_4'"; }
                        //end of query for second subcategory drop down list box
                        echo "<form method=post name=f1 action='dd-check.php'>";
                        //form processing page address to action in above line
                        //Starting of first drop downlist
                        echo "<select name='cat' onchange=\"reload(this.form)\"><option value=''>Select Department</option>";
                        foreach ($dbo->query($quer2) as $noticia2) {
                            if($noticia2['cat_id']==@$cat){echo "<option selected value='$noticia2[cat_id]'>$noticia2[category]</option>"."<BR>";}
                            else{echo  "<option value='$noticia2[cat_id]'>$noticia2[category]</option>";}
                        }
                        echo "</select>";
                        //This will end the first drop down list
                        //Starting of second drop downlist
                        echo "<select name='subcat'><option value=''>Select TA</option>";
                        foreach ($dbo->query($quer) as $noticia) {
                            echo  "<option value='$noticia[subcategory]'>$noticia[subcategory]</option>";
                        }
                        echo "</select>";
                        //////////////////  This will end the second drop down list
                        echo "<div class='field'><label for='room'>Room#</label><input type='text' id='room' name='room' placeholder='Room#' required></div>";
                        echo "<div class='field'><label for='computer'>Computer#</label><input type='text' id='Computer' name='Computer' placeholder='Computer#' required></div>";
                        echo "<div class='field'><label for='course'>Course</label><input type='text' id='course' name='course' placeholder='Course' required></div>";
                        echo "<div class='field'><label for='problem'>Problem</label><textarea id='problem' name='problem' placeholder='Problem' wrap='hard' required></textarea></div>";
                        //// Add your other form fields as needed here/////
                        //echo "<input type=submit value=Submit>";
                        echo "</form>";
                        ?>

                        <div class="form-group">

                            <button type="submit" id="submit-btn" onClick="getTimeStamp()";return false;" class="btn btn-primary btn-block">Submit Ticket &nbsp; <i class="fa fa-play-circle"></i></button>	</div>
                    </div>
                </div>
            </form>
        </form>
    </div>
</div> <!-- /#login -->
<!--    JS FILES         -->
<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--   END OF JS FILES    -->
</body>
</html>
