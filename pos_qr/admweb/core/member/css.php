<!--Bootstrap Validator [ OPTIONAL ]-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="<?php echo TEMPLATE_URL; ?>/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">
<style>
    .valid {
        color: green;
    }

    .valid:before {

        position: relative;
        left: -35px;
        content: "✔";
    }

    .invalid {
        color: red;
    }

    .invalid:before {
        position: relative;
        left: -35px;
        content: "✘";
    }

    .phone12 {
        margin: 15px auto;
        padding: 4px;
        border-radius: 40px;
        width: auto;
        display: inline-block;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 3px 15px rgba(0, 0, 0, 0.35);
        -webkit-box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 3px 15px rgba(0, 0, 0, 0.35);
        -moz-box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25), 0 3px 15px rgba(0, 0, 0, 0.35);
        position: relative;
    }

    .phone12:before {
        content: '';
        position: absolute;
        left: -4px;
        top: 200px;
        width: 4px;
        height: 50px;
        background: #000;
        display: block;
        border-radius: 4px 0 0 4px;
    }

    .phone12:after {
        content: '';
        position: absolute;
        left: -4px;
        top: 260px;
        width: 4px;
        height: 50px;
        background: #000;
        display: block;
        border-radius: 4px 0 0 4px;
    }

    .phone12 .screenborder {
        width: auto;
        height: auto;
        padding: 4px;
        border-radius: 36px;
        display: block;
        border: rgba(255, 255, 255, 0.2) 0px solid;
        box-shadow: 0 0px 5px rgba(0, 0, 0, 0.55), inset 1px 0px 3px rgba(255, 255, 255, 0.55);
        -webkit-box-shadow: 0 0px 5px rgba(0, 0, 0, 0.55), inset 1px 0px 3px rgba(255, 255, 255, 0.55);
        -moz-box-shadow: 0 0px 5px rgba(0, 0, 0, 0.55), inset 1px 0px 3px rgba(255, 255, 255, 0.55);
        position: relative;
    }

    .phone12 .screenborder:before {
        content: '';
        position: absolute;
        right: -7px;
        top: 200px;
        width: 4px;
        height: 100px;
        background: #000;
        display: block;
        border-radius: 0 4px 4px 0;
    }

    .phone12 .screenborder .screen12 {
        width: 375px;
        display: block;
        height: 792px;
        padding: 8px;
        border-radius: 32px;
        background-color: #000;
        position: relative;
    }

    .phone12 .screenborder .screen12 iframe {
        display: none;
        width: 360px;
        border: 0;
        border-radius: 26px;
        height: 776px;
    }

    .phone12.blue,
    .phone12.blue .screenborder {
        background: #000;
        background: linear-gradient(40deg, #6BC048 0%, #4CAF50 50%, #2E7D32 100%);
    }
</style>