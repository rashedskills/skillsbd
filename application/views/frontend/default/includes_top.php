<link rel="favicon" href="<?php echo base_url().'assets/frontend/default/img/icons/favicon.ico' ?>">
<link rel="apple-touch-icon" href="<?php echo base_url().'assets/frontend/default/img/icons/icon.png'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/jquery.webui-popover.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/select2.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/slick.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/slick-theme.css'; ?>">
<!-- font awesome 5 -->
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/fontawesome-all.min.css'; ?>">

<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/bootstrap.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/bootstrap-tagsinput.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/main.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/responsive.css'; ?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url().'assets/global/toastr/toastr.css' ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" />
<script src="<?php echo base_url('assets/backend/js/jquery-3.3.1.min.js'); ?>"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<style>
.hovereffect {
  width: 100%;
  height: 100%;
  float: left;
  overflow: hidden;
  position: relative;
  text-align: center;
  cursor: default;
  border-radius: 6px;
  background: #36373c;
}

.hovereffect .overlay {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  top: 0;
  left: 0;
  padding: 100px 30px;
}

.hovereffect img {
  display: block;
  position: relative;
  max-width: none;
  width: calc(100% + 20px);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(-10px,0,0);
  transform: translate3d(-10px,0,0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
}

.hovereffect:hover img {
  opacity: 0.4;
  filter: alpha(opacity=40);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

.hovereffect h2 {
  color: #fff;
  text-align: center;
  position: relative;
  font-size: 22px;
  font-weight: bold;
  overflow: hidden;
  padding: 0.5em 0;
  background-color: transparent;
}

.hovereffect h2:after {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: #fff;
  content: '';
  -webkit-transition: -webkit-transform 0.35s;
  transition: transform 0.35s;
  -webkit-transform: translate3d(-100%,0,0);
  transform: translate3d(-100%,0,0);
}

.hovereffect:hover h2:after {
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

.hovereffect a, .hovereffect p {
  color: #FFF;
  opacity: 0;
  filter: alpha(opacity=0);
  -webkit-transition: opacity 0.35s, -webkit-transform 0.35s;
  transition: opacity 0.35s, transform 0.35s;
  -webkit-transform: translate3d(100%,0,0);
  transform: translate3d(100%,0,0);
}

.hovereffect:hover a, .hovereffect:hover p {
  opacity: 1;
  filter: alpha(opacity=100);
  -webkit-transform: translate3d(0,0,0);
  transform: translate3d(0,0,0);
}

</style>
