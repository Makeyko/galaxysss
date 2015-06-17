/**
 *
 * @type {{init: Function}}
 */
var Place = {
    init: function(fieldName) {
		$('#' + fieldName + '_country-name').autocomplete({
			source: "/place/country",
			select: function (event, ui) {
                $('#' + fieldName + '_country').val(ui.item.id);
                $('#' + fieldName + '_region').val('');
                $('#' + fieldName + '_region-name').val('');
                $('#' + fieldName + '_town').val('');
                $('#' + fieldName + '_town-name').val('');
			}
		});
		$('#' + fieldName + '_region-name').autocomplete({
			source: function(req, resp) {
				$.get('/place/region', {
					term: req.term,
					country: $('#' + fieldName + '_country').val()
				}, function(answer) {
					resp(answer);
				}, 'json');
			},
			select: function (event, ui) {
				$('#' + fieldName + '_region').val(ui.item.id);
				$('#' + fieldName + '_town').val('');
				$('#' + fieldName + '_town-name').val('');
				$('#' + fieldName + '_country').val(ui.item.country_id);
				$('#' + fieldName + '_country-name').val(ui.item.country_name);
				
			}
		});
		$('#' + fieldName + '_town-name').autocomplete({
			source: function(req, resp) {
				$.get('/place/town', {
					term: req.term,
					country: $('#' + fieldName + '_country').val(),
					region: $('#' + fieldName + '_region').val()
				}, function(answer) {
					resp(answer);
				}, 'json');
			},
			select: function (event, ui) {
				$('#' + fieldName + '_region').val(ui.item.region_id);
				$('#' + fieldName + '_country').val(ui.item.country_id);
				if(ui.item.region_name) {
					$('#' + fieldName + '_region-name').val(ui.item.region_name);
				}
				$('#' + fieldName + '_country-name').val(ui.item.country_name);
				$('#' + fieldName + '_town').val(ui.item.id);
			}
		});
    }
};
