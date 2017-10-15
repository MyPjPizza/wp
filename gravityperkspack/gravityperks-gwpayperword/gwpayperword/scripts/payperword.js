/**
* GWPayPerWord Object
*
* @param formId
* @param ppwFields
*/

var GWPayPerWord = function(formId, ppwFields) {

    this.init = function(formId, ppwFields) {

        var gwppw = this;

        for(var i in ppwFields) {
            var ppwField = jQuery.extend({}, ppwFields[i]);
            gwppw.updatePrice(ppwField, formId);
            gwppw.bindEvents(ppwField, formId);
        }

    }

    this.updatePrice = function(ppwField, formId) {
        var gwppw = this;

        // get field objects
        var wordField = jQuery('#input_' + formId + '_' + ppwField.word_field);
        var priceField = jQuery('#ginput_base_price_' + formId + '_' + ppwField.price_field);
        var priceFieldSpan = jQuery('#input_' + formId + '_' + ppwField.price_field);

        var text       = jQuery.trim( wordField.val() ),
            words      = text.match( /\S+/g ),
            wordCount  = gform.applyFilters( 'gpppw_word_count', words == null ? 0 : words.length, text, gwppw, ppwField, formId );

        var price = 0;
        var pricePerWord = parseFloat( ppwField.price_per_word );
        var basePrice = (isNaN(parseFloat(ppwField.base_price))) ? 0 : parseFloat( ppwField.base_price );
        var baseCount = (isNaN(parseFloat(ppwField.base_word_count))) ? 0 : parseFloat( ppwField.base_word_count );

        var isVisible = window['gf_check_field_rule'] ? gf_check_field_rule(formId, ppwField.word_field, true, '') == 'show' : true;

        // calculate price
        if( ! isVisible || ( wordCount <= 1 && words == null ) ) {
            price = 0;
        } else if(wordCount > baseCount) {
            extraWordsCount = wordCount - baseCount;
            price = basePrice;
            price += extraWordsCount * pricePerWord;
        } else {
            price = basePrice;
        }

        price = gform.applyFilters( 'gwppw_price', price, wordCount, pricePerWord, ppwField, formId );
        price = gform.applyFilters( 'gpppw_price', price, wordCount, pricePerWord, ppwField, formId );

        // format price
        labelPrice = gformFormatMoney(price);

        priceField.val( labelPrice ).change();
        priceFieldSpan.text(labelPrice);

        gformCalculateTotalPrice(formId);

    }

    this.bindEvents = function(ppwField, formId) {

        var gwppw = this;
        var wordField = jQuery('#input_' + formId + '_' + ppwField.word_field);

        // bind on keyup
        wordField.keyup(function() { 
            gwppw.updatePrice(ppwField, formId);
        });

        // bind on conditional logic hook
        jQuery(document).bind('gform_post_conditional_logic', function(){
            gwppw.updatePrice(ppwField, formId);
        });

    }

    this.init(formId, ppwFields);

}