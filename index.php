<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="chrome">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Calendar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
    error_reporting(0);
    require './calendar.php';
    $cal = new Calendar();

    if (isset($_POST['next'])){
        $cal->setVar($_SESSION['var']+=1);
    }
    else if (isset($_POST['next2'])){
        $cal->setVar($_SESSION['var']+=12);
    }
    else if (isset($_POST['next3'])){
        $cal->setVar($_SESSION['var']+=60);
    }
    else if (isset($_POST['back'])){
        $cal->setVar($_SESSION['var']-=1);
    }
    else if (isset($_POST['back2'])){
        $cal->setVar($_SESSION['var']-=12);
    }
    else if (isset($_POST['back3'])){
        $cal->setVar($_SESSION['var']-=60);
    }
    else if (isset($_POST['current'])){
        $cal->setVar($_SESSION['var']=0);
    }
    
    $y= date('Y');
    $m= date('n');
   // $var = 6000; //  12 - 1 rok 60 - 5 lat

    echo $cal->print_table($cal->getVar());
?>

<center>
    <form action="index.php" method="POST">
    <div class="div-buttons marg">
        <button type="submit" class="btn btn2 marg-r" id="back" name="back"> <!--1 miesiąc -->
            <span class="s6"></span>
            <span class="s7"></span>
            <b><</b>
        </button>
        <button type="submit" class="btn btn2 marg-r" id="back2" name="back2"><!--1 rok -->
            <span class="s6"></span>
            <span class="s7"></span>
            <b><<</b>
        </button>
        <button type="submit" class="btn btn2 marg-r" id="back3" name="back3"><!--5 lat -->
            <span class="s6"></span>
            <span class="s7"></span>
            <b><<<</b>
        </button>
        <div class="space form-log">
            <?php echo $cal->YearMonth($m,$cal->getVar());?><br>
                <button type="submit" class="btn" id="current" name="current"><!--5 lat -->
                <span class="s1"></span>
                <span class="s2"></span>
                <span class="s3"></span>
                <span class="s4"></span>
                Today
                </button>
        </div>
        <button type="submit" class="btn  btn2 marg-r" id="next3" name="next3"><!--5 lat -->
            <span class="s5"></span>
            <span class="s8"></span>
            <b>>>></b>
        </button>
        <button type="submit" class="btn  btn2 marg-r" id="next2" name="next2"><!--1 rok -->
            
            <span class="s5"></span>
            <span class="s8"></span>
            <b>>></b>
        </button>
        <button type="submit" class="btn  btn2 marg-r" id="next" name="next"><!--1 miesiąc -->
            <span class="s5"></span>
            <span class="s8"></span>
            <b>></b>
        </button>
    </div>
    </form>
</center>
<script>
    date=new Date();
    if (date.getHours()==0){
        window.location.reload;
    }
</script>
</body>
</html>
