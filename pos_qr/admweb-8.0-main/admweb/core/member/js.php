<!--Bootstrap Validator [ OPTIONAL ]-->
<script src="<?php echo TEMPLATE_URL; ?>/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
<!--Masked Input [ OPTIONAL ]-->
<script src="<?php echo TEMPLATE_URL; ?>/plugins/masked-input/jquery.maskedinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
  $(document).on('nifty.ready', function() {
    $('.msk-phone').mask('(999) 999-9999');
    $('.msk-namecard').mask('9-9999-99999-99-9');
    $('.adminStatusChange').click(function() {
      v = $(this).val();
      if (v == 'admin') {
        $('.checkall').prop('checked', 'checked');
        checkAllList();
      }
    });
  });

  flatpickr("#datePicker", {
    dateFormat: "d-m-Y",
  });

  function checkAllList() {
    if ($('.checkall').is(':checked')) {
      $(':checkbox.checkpoint').prop('checked', 'checked');
      $(':checkbox.checkallmodule').prop('disabled', true);
      $(':checkbox.checkallmodule').prop('checked', '');
    } else {
      $(':checkbox.checkpoint').prop('checked', '');
      $(':checkbox.checkallmodule').prop('disabled', false);
    }
  }

  function checkAllModule(module) {
    if ($('.checkall-' + module).is(':checked')) {
      $(':checkbox.' + module).prop('checked', 'checked');
    } else {
      $(':checkbox.' + module).prop('checked', '');
    }
  }

  $(':checkbox.checkpoint').on('change', function(e) {
    if ($(this).is(':checked') == false && $('.checkall').is(':checked') == true) {
      $('.checkall').prop('checked', '');
      $(':checkbox.checkallmodule').prop('disabled', false);
    }
  });

  function changepasscheck(c) {
    if (c.checked) {
      $('#changepassword').before('<div class="form-group"><ul id="cmessage"><li id="clangth">จำนวนตัวอักษร 8 ตัวขึ้นไป</li><li id="cletter">ต้องมีตัวพิมพ์เล็กอย่างน้อย 1 ตัว</li><li id="ccapital">ต้องมีตัวพิมพ์ใหญ่อย่างน้อย 1 ตัว</li><li id="cspacialchar">ต้องมีอักขระพิเศษอย่างน้อย 1 ตัว</li><li id="cnumber">ต้องมีตัวเลขอย่างน้อย 1 ตัว</li><li id="comfpass">ยืนยันรหัสผ่านตรงกัน</li></ul></div>');
      $('.changepasscheck').removeAttr('disabled');
      $('.changepasscheck2').removeAttr('disabled');
      $('.changepasscheck').after('<span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" onclick="dpass(\'toggle-password\', \'password\');"></span>');
      $('.changepasscheck2').after('<span class="fa fa-fw fa-eye field-icon toggle-password2" onclick="dpass(\'toggle-password2\', \'password2\');"></span>');
      passwordValidate();
    } else {
      $('.changepasscheck').attr('disabled', 'disabled');
      $('.changepasscheck2').attr('disabled', 'disabled');
      $('#cmessage').parent().remove();
      $('.toggle-password').remove();
      $('.toggle-password2').remove();
    }
  }

  function passwordValidate() {
    var myInput = document.getElementById("pwdf") ? document.getElementById("pwdf") : document.getElementById("password");
    var myInputCf = document.getElementById("pwdfcf") ? document.getElementById("pwdfcf") : document.getElementById("password2");
    var letter = document.getElementById("cletter");
    var capital = document.getElementById("ccapital");
    var number = document.getElementById("cnumber");
    var length = document.getElementById("clangth");
    var cspacialchar = document.getElementById("cspacialchar");
    var comfpass = document.getElementById("comfpass");

    myInputCf.onkeyup = function() {
      if (myInput.value == myInputCf.value && myInput.value !== "" && myInputCf.value !== "") {
        comfpass.classList.remove("invalid");
        comfpass.classList.add("valid");
      } else {
        comfpass.classList.remove("valid");
        comfpass.classList.add("invalid");
      }
    }

    myInput.onkeyup = function() {

      // Validate lowercase letters
      var lowerCaseLetters = /[a-z]/g;
      if (myInput.value.match(lowerCaseLetters)) {
        letter.classList.remove("invalid");
        letter.classList.add("valid");
      } else {
        letter.classList.remove("valid");
        letter.classList.add("invalid");
      }

      // Validate capital letters
      var upperCaseLetters = /[A-Z]/g;
      if (myInput.value.match(upperCaseLetters)) {
        capital.classList.remove("invalid");
        capital.classList.add("valid");
      } else {
        capital.classList.remove("valid");
        capital.classList.add("invalid");
      }

      var cspacialcharCase = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/g;
      if (myInput.value.match(cspacialcharCase)) {
        cspacialchar.classList.remove("invalid");
        cspacialchar.classList.add("valid");
      } else {
        cspacialchar.classList.remove("valid");
        cspacialchar.classList.add("invalid");
      }

      // Validate numbers
      var numbers = /[0-9]/g;
      if (myInput.value.match(numbers)) {
        number.classList.remove("invalid");
        number.classList.add("valid");
      } else {
        number.classList.remove("valid");
        number.classList.add("invalid");
      }

      if (myInput.value == myInputCf.value && myInput.value !== "" && myInputCf.value !== "") {
        comfpass.classList.remove("invalid");
        comfpass.classList.add("valid");
      } else {
        comfpass.classList.remove("valid");
        comfpass.classList.add("invalid");
      }

      // Validate length
      if (myInput.value.length >= 8) {
        length.classList.remove("invalid");
        length.classList.add("valid");
      } else {
        length.classList.remove("valid");
        length.classList.add("invalid");
      }
    }

    var formSubmit = document.getElementById("changepass") ? document.getElementById("changepass") : document.getElementById("form1");

    formSubmit.onsubmit = function() {
      if (myInput.value == '') {
        return true;
      }
      var cspacialcharCase = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/g;
      if (myInput.value.match(cspacialcharCase) && myInput.value == myInputCf.value) {
        return true;
      } else {
        myInput.focus();
        return false;
      }
    };
  }

  <?php if ($_REQUEST['mp'] == 'changePass' || $_REQUEST['mp'] == 'admin_add') { ?>
    passwordValidate();
  <?php } ?>

  function AddResetPass() {
    document.getElementById("pwsf").value = '<?php echo PW_RESET; ?>';
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('.blah')
          .attr('src', e.target.result).width(150);
      };

      reader.readAsDataURL(input.files[0]);
    }
    $('.displayselect').fadeIn();
  }

  function dpass(sname, inputid) {
    $('.' + sname).toggleClass("fa-eye fa-eye-slash");
    var input = $('#' + inputid);
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  }

  function resetBirthday() {
    document.getElementById("datePicker").value = '';
  }
</script>