<div >
    <ul id="menulist"></ul>
</div>
<script type="text/template" id="menu-list-item">
    <li><a href='#wines/<%= id %>'><%= name %></a></li>
</script>
<div class="header"></div>
<div class="center"></div>
<div class="foots"></div>
<!-- /.container -->
<div id="logger"></div>
<!-- /.logger -->
<script data-main="<?php echo Yii::app()->request->baseUrl; ?>/static/app/js/main"
    src="<?php echo Yii::app()->request->baseUrl; ?>/static/app/js/libs/require/require.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/static/app/js/utils.js"></script>