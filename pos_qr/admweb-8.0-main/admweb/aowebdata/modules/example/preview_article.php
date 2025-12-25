<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PreviewDemo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="th-tab" data-toggle="tab" href="#th" role="tab" aria-controls="th" aria-selected="true">TH</a></li>
        <li class="nav-item"><a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">EN</a></li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="th" role="tabpanel" aria-labelledby="th-tab">
            <br>
            <div><?php echo $_SESSION['frm[th][subject]']; ?></div>
            <?php if (!empty($_SESSION['icon'])) { ?>
                <img src="<?php echo $_SESSION['icon']; ?>" alt="">
            <?php } ?>
        </div>
        <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
            <br>
            <div><?php echo $_SESSION['frm[en][subject]']; ?></div>
            <?php if (!empty($_SESSION['icon2'])) { ?>
                <img src="<?php echo $_SESSION['icon2']; ?>" alt="">
            <?php } ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<!-- <pre>Array
(
    [formData] => ac=edit&id=94&status=y&group=0&displaytime=07%2F18%2F2024&endDate=09%2F23%2F2024&isEndDateShow=1&icon=&icon2=&checkOption=0&extra1=&extra2=&extra3=&extra4=&extra5=&extra6=&extra7=&extra8=&extra9=&extra10=&frm%5Bth%5D%5Bcontent_id%5D=&frm%5Bth%5D%5Bsubject%5D=test00012&frm%5Bth%5D%5Bkeywords%5D=test00012&frm%5Bth%5D%5Bauthor%5D=test00012&frm%5Bth%5D%5BshortMessage%5D=test00012&frm%5Bth%5D%5Bcontent%5D=%3Cp%3Etest00012%3Cbr%3E%3C%2Fp%3E&frm%5Bth%5D%5Bcontent2%5D=%3Cp%3Etest00012%3Cbr%3E%3C%2Fp%3E&frm%5Bth%5D%5Bcontent3%5D=%3Cp%3Etest00012%3Cbr%3E%3C%2Fp%3E&frm%5Bth%5D%5Bcontent4%5D=&frm%5Bth%5D%5Bcontent_extra1%5D=&frm%5Bth%5D%5Bcontent_extra2%5D=&frm%5Bth%5D%5Bcontent_extra3%5D=&frm%5Ben%5D%5Bcontent_id%5D=&frm%5Ben%5D%5Bsubject%5D=-%20-%20No%20title%20-%20-&frm%5Ben%5D%5Bkeywords%5D=&frm%5Ben%5D%5Bauthor%5D=&frm%5Ben%5D%5BshortMessage%5D=&frm%5Ben%5D%5Bcontent%5D=&frm%5Ben%5D%5Bcontent2%5D=&frm%5Ben%5D%5Bcontent3%5D=&frm%5Ben%5D%5Bcontent4%5D=&frm%5Ben%5D%5Bcontent_extra1%5D=&frm%5Ben%5D%5Bcontent_extra2%5D=&frm%5Ben%5D%5Bcontent_extra3%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=&attachTextFileList%5B%5D=
    [keysname] => article
    [ac] => edit
    [id] => 94
    [status] => y
    [group] => 0
    [displaytime] => 07/18/2024
    [endDate] => 09/23/2024
    [isEndDateShow] => 1
    [icon] => 
    [icon2] => 
    [checkOption] => 0
    [extra1] => 
    [extra2] => 
    [extra3] => 
    [extra4] => 
    [extra5] => 
    [extra6] => 
    [extra7] => 
    [extra8] => 
    [extra9] => 
    [extra10] => 
    [frm[th][content_id]] => 
    [frm[th][subject]] => 123
    [frm[th][keywords]] => 123
    [frm[th][author]] => 123
    [frm[th][shortMessage]] => 231
    [frm[th][content]] => <p>test00012<br></p>
    [frm[th][content2]] => <p>test00012<br></p>
    [frm[th][content3]] => <p>test00012<br></p>
    [frm[th][content4]] => 
    [frm[th][content_extra1]] => 
    [frm[th][content_extra2]] => 
    [frm[th][content_extra3]] => 
    [frm[en][content_id]] => 
    [frm[en][subject]] => - - No title - -
    [frm[en][keywords]] => 
    [frm[en][author]] => 
    [frm[en][shortMessage]] => 
    [frm[en][content]] => 
    [frm[en][content2]] => 
    [frm[en][content3]] => 
    [frm[en][content4]] => 
    [frm[en][content_extra1]] => 
    [frm[en][content_extra2]] => 
    [frm[en][content_extra3]] => 
    [attachTextFileList[0]] => 
    [attachTextFileList[1]] => 
    [attachTextFileList[2]] => 
    [attachTextFileList[3]] => 
    [attachTextFileList[4]] => 
    [attachTextFileList[5]] => 
    [attachTextFileList[6]] => 
    [attachTextFileList[7]] => 
)
</pre> -->