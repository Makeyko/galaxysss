{*
[
    'rows'     => $this->rows = 0 => [
                'id' => '524'
                'name' => '123456'
                'logo' => null
                'rating' => '569'
                'feedback_count' => '2'
            ],
    'formName' => $this->model->formName(), // string
    'model'    => $this->model, // \yii\base\Model
    'attrId'   => $this->attrId, // attribute id
    'attrName' => $this->attrName, // attribute name
    'templateVariables' => []
]

Обязательные поля
<input type="checkbox" id="#{attrId}-check-all-input"> // поле общее для всех checkbox
<(label) id="'#{attrId}-check-all"> // поле на которое навешивается событие on click

*}


<div class="bank_list_head">
    <div class="bank_list_check">
        <input type="checkbox" value="" name="" class="display_none" id="{$attrId}-check-all-input">
        <label for="" id="{$attrId}-check-all"></label>
    </div>
    <div class="bank_list_name">Название организации</div>
    <div class="bank_list_reviews">Отзывы</div>
    <div class="bank_list_rating">Рейтинг</div>
</div>


<div id="{$attrId}" class="banks_list">
    {foreach key=id item=item from=$rows}
        <div class="bank_list_row">
            <div class="bank_list_check">
                <input type="checkbox" id="{$attrId}-{$item.id}" class="display_none" name="{$attrName}[]" value="{$item.id}">
                <label for="{$attrId}-{$item.id}"></label>
            </div>
            <a class="bank_list_name" href="/banks/524">
                <span class="bank_logo" {if $item.logo}style="background-image:url(&quot;//{$templateVariables.bankServerName}{$item.logo}&quot;)"{/if}></span>
                <span class="bank_name">{$item.name}</span>
            </a>
			{if $item.feedback_count}
				<a class="bank_list_reviews" href="/banks/{$item.id}">{$item.feedback_count}</a>
			{/if}
            <div class="bank_list_rating">{$item.rating}</div>
        </div>
    {/foreach}
</div>

