{*
[
    'value'    => '/uploads/...',
    'original' => '/uploads/...', // оригинал изображения
    'formName' => $this->model->formName(), // string
    'model'    => $this->model, // \yii\base\Model
    'attrId'   => $this->attrId, // attribute id
    'attrName' => $this->attrName, // attribute name
    'widgetOptions' => $widgetOptions, // widgetOptions опции переданные при конфигурации виджета в widgetOptions
]
 *}


<div class="photo_form {$widgetOptions.class}">
	
	{if $value}
	
		<div class="photo_form_img" style="background-image:url({$value})" id="{$attrId}-img">
		
			<div class="photo_form_actions">

				<div class="photo_form_action" id="{$attrId}-delete">
					Удалить
				</div>
			
			</div>
			
		</div>

        <div class="photo_form_upload blue_button">
			Изменить
			<input type="file" name="{$attrName}" id="{$attrId}" accept="image/*">
		</div>

        <div id="{$attrId}-img_name">
		
		</div>
	
	{else}
		
		<div class="photo_form_upload blue_button">
			Загрузить
			<input type="file" name="{$attrName}" id="{$attrId}" accept="image/*">
		</div>

        <div id="{$attrId}-img_name">

		</div>
	
	{/if}
    <input type="hidden" name="{$attrName}" id="{$attrId}-value" value="{$value}">



</div>


