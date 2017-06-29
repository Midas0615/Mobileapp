<div class="row nm cloneMe">
    <div class="col-md-3">
        <div class="form-group">        
            <?php echo CHtml::dropDownList("ChemistryDetail[" . $counter . "][term_id]", !empty($data['term_id']) ? $data['term_id'] : "", $terms, array("class" => "addmore-required form-control term_id", "prompt" => $chemistry_detail->getAttributeLabel('term_id'))); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo CHtml::textField("ChemistryDetail[" . $counter . "][start]", !empty($data['start']) ? $data['start'] : "", array("class" => "addmore-required form-control start", "placeholder" => $chemistry_detail->getAttributeLabel('start'))); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo CHtml::textField("ChemistryDetail[" . $counter . "][end]", !empty($data['end']) ? $data['end'] : "", array("class" => "addmore-required form-control end", "placeholder" => $chemistry_detail->getAttributeLabel('end'))); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo CHtml::dropDownList("ChemistryDetail[" . $counter . "][main_unit]", !empty($data['main_unit']) ? $data['main_unit'] : "", $uom, array("class" => "addmore-required form-control main_unit", "prompt" => $chemistry_detail->getAttributeLabel('main_unit'))); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <?php echo CHtml::dropDownList("ChemistryDetail[" . $counter . "][per_unit]", !empty($data['per_unit']) ? $data['per_unit'] : "", $uom, array("class" => "addmore-required form-control per_unit", "prompt" => $chemistry_detail->getAttributeLabel('per_unit'))); ?>
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <?php
            $removeStyle = ($counter > 0) ? '' : 'display:none;';
            $addStyle = ($counter == 0) ? '' : 'display:none;';
            ?>
            <?php echo CHtml::Link('<i class="ico-plus"></i>', "javascript:;", array("class" => "btn btn-sm btn-default addBtn", 'onclick' => 'cloneMe(this)', "style" => $addStyle)); ?>
            <?php echo CHtml::Link('<i class="ico-minus"></i>', "javascript:;", array("class" => "btn btn-sm btn-default removeBtn", 'onclick' => 'removeMe(this)', "style" => $removeStyle)); ?>
        </div>
    </div>
</div>