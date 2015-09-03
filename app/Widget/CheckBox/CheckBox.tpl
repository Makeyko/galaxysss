{* $contnt - Содержимое label *}
{* $id - id поля *}
{* $name - name поля *}
{* $formName - formName *}
{* $checked - formName *}

<label class="checkbox_imitation">
    <input type="checkbox" class="checkbox_hidden" name="{$name}" value="1" {if ($checked)}checked="checked"{/if}>
    <span></span>
    <span class="checkbox_text">{$contnt}</span>
</label>