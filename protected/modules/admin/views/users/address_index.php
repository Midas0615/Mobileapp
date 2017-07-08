<?php
/**
 * This script is developed by Alpesh Vaghela
 * used in Settings Controller and Teams Action
 * @uses To display View Page
 * @name  	admin.php
 * @package views.settings
 * @author 	Alpesh Vaghela
 * @since 	25-04-2013
 */
?>
<div class="container-fluid">
    <div class="row-fluid">
	<div class="area-top clearfix">
	    <div class="pull-left header">
		<?php echo common::setTitle("icon-group"); ?>
	    </div>
	</div>
    </div>
</div>
<div class="container-fluid padded">
    <?php $this->renderPartial("application.views.layouts._message"); ?>
    <div class="row-fluid">
	<div class="span8">
	    <div class="box">
		<div class="box-header">
		    <span class="title">Teams</span>
		</div>
		<div class="box-content">                    
		    <?php
		    $updateRight = common::checkActionAccess('settings/updateteam');
		    $deleteRight = common::isDRCAdmin();
		    $actionStyle = (!$updateRight && !$deleteRight) ? "display:none" : "";
		    $this->widget('CustomGridView', array(
			'id' => 'teams-grid',
			'dataProvider' => $model->search(),
			'afterAjaxUpdate' => 'function() {}',
			'htmlOptions' => array('class' => 'yiigridview'),
			'ajaxUpdate' => true,
			'enablePagination' => true,
			"summaryText" => true,
			'itemsCssClass' => 'responsive dataTable',
			'selectableRows' => 2,
			"template" => "{items}\n<div class=\"table-footer\">{summary}{pager}</div>",
			"summaryText" => "<div class=\"dataTables_info\">Showing {start} to {end} of {count} entries</div>",
			'pagerCssClass' => 'dataTables_paginate paging_full_numbers',
			'pager' => array(
			    'class' => 'CustomLinkPager',
			    'maxButtonCount' => 5,
			    'nextPageLabel' => 'Next',
			    'prevPageLabel' => 'Prev',
			    'firstPageLabel' => 'First',
			    'lastPageLabel' => 'Last',
			),
			'filter' => $model,
			'columns' => array(
			    array(
				'name' => 'team_name',
				'type' => 'raw',
                                'htmlOptions'=>array("width"=>"75%","class"=>"text-left")                                
			    ),
			    array(
				'class' => 'CButtonColumn',
				'header' => 'Action',
				'template' => '{update}{deleteTeam}',
				'headerHtmlOptions' => array('style' => $actionStyle, 'width' => '10%'),
				'htmlOptions' => array('class' => 'button-column', 'width' => '10%', 'style' => $actionStyle),
				'buttons' => array(
				    'deleteTeam' => array(
					'label' => '<i class="icon-trash wysiwyg-color-red"></i>',
					'url' => 'Yii::app()->createUrl("".Yii::app()->controller->id."/deleteteam", array("id" =>$data["team_id"]))',
					'options' => array("title" => "Delete Record", "class" => "delete", "style" => "margin-right:10px"),
					'visible' => "$deleteRight",
					'imageUrl' => false
				    ),
				    'update' => array(
					'label' => '<i class="icon-pencil"></i>',
					'url' => 'Yii::app()->createUrl("".Yii::app()->controller->id."/updateteam", array("id" =>$data["team_id"]))',
					'options' => array('title' => 'Update Record', "class" => "update", "style" => "margin-right:10px"),
					'visible' => "$updateRight",
					'imageUrl' => false
				    ),
				)
			    ),
			),
		    ));
		    Yii::app()->clientScript->registerScript('yiiGridView.delete', "
		    jQuery('.button-column a.delete').live('click',function() {
			if(confirm('Are you sure you want to delete this item?',true)){
			    var th=this;
			    var afterStatus=function(){};
			    $.fn.yiiGridView.update('teams-grid', {
				type:'POST',
				url:$(this).attr('href'),
				success:function(data) {
				    $('#flash-message').show().html(data);
				    $('#flash-message').animate({opacity: 1.0}, 10000).fadeOut('slow');
				    $.fn.yiiGridView.update('teams-grid');
				},
				error:function(XHR) {
				    return afterStatus(th,false,XHR);
				}
			    });
			}
			return false;
		    });
		    ");?>
		</div>
	    </div>
	</div>
	<div class="span4">	    
	    <?php $this->renderPartial("_form_teams", array("model" => $model)); ?>
	</div>
    </div>
</div>
