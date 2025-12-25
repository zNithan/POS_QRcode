<link href="<?php echo TEMPLATE_URL; ?>/plugins/pace/pace.min.css?<?php echo CACHE_VERSION; ?>" rel="stylesheet">
<script src="<?php echo TEMPLATE_URL; ?>/plugins/pace/pace.min.js?<?php echo CACHE_VERSION; ?>"></script>
<link href="<?php echo TEMPLATE_URL; ?>/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.css?<?php echo CACHE_VERSION; ?>" rel="stylesheet">
<link href="<?php echo TEMPLATE_URL; ?>/plugins/summernote/summernote.min.css?<?php echo CACHE_VERSION; ?>" rel="stylesheet">
<link href="<?php echo TEMPLATE_URL; ?>/plugins/bootstrap-select/bootstrap-select.min.css?<?php echo CACHE_VERSION; ?>" rel="stylesheet">
<link href="<?php echo TEMPLATE_URL; ?>/plugins/select2/css/select2.min.css?<?php echo CACHE_VERSION; ?>" rel="stylesheet">
<link href="<?php echo TEMPLATE_URL; ?>/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css?<?php echo CACHE_VERSION; ?>" rel="stylesheet">
<link href="<?php echo TEMPLATE_URL; ?>/plugins/animate-css/animate.min.css?<?php echo CACHE_VERSION; ?>" rel="stylesheet">

<?php
if (_MP_ == 'hashfile') { ?>
    <style>
       .table>thead>tr.active{ background: linear-gradient(to bottom, #f5f5f5 0%, #e8e8e8 100%);} .table>thead>tr>th{ font-weight: 600; border-bottom: 2px solid #ddd; padding: 12px 8px;} .table>tbody>tr{ transition: background-color 0.2s;} .table>tbody>tr:hover{ background-color: #f5f9fc;} .table>tbody>tr>td{ border-color: #e0e0e0;} [data-toggle="collapse"]{ transition: background-color 0.2s;} [data-toggle="collapse"]:hover{ background-color: #f0f0f0 !important;} .collapse{ transition: height 0.3s ease;} [style*="overflow-y: auto"]::-webkit-scrollbar{ width: 8px;} [style*="overflow-y: auto"]::-webkit-scrollbar-track{ background: #f1f1f1; border-radius: 4px;} [style*="overflow-y: auto"]::-webkit-scrollbar-thumb{ background: #888; border-radius: 4px;} [style*="overflow-y: auto"]::-webkit-scrollbar-thumb:hover{ background: #555;} .table .alert-success{ padding: 6px 10px; margin: 0; font-size: 12px; display: inline-block; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border: 1px solid #10b981; color: #065f46; border-radius: 4px;}
    </style>
<?php } ?>