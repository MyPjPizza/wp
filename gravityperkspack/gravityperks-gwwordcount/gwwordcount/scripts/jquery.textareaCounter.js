/**
 * jQuery.textareaCounter
 * Version 1.0
 * Copyright (c) 2011 c.bavota - http://bavotasan.com
 * Dual licensed under MIT and GPL.
 * Date: 10/20/2011
**/
(function($){
    
    $.fn.textareaCounter = function( options ) {
        
        // setting the defaults
        var defaults = {
            showCount: true,
            limit:     100,
            min:       0,
            truncate:  true
        };
        
        var txtCounterObj = this,
            options       = $.extend( defaults, options ),
            previousCount = 0;
        
        this.updateWordCount = function( obj, counterLabel ) {

            var text          = $.trim( obj.val() ),
                words         = text.match( /\S+/g ),
                wordCount     = gform.applyFilters( 'gpwc_word_count', words == null ? 0 : words.length, text, obj ),
                origWordCount = wordCount,
                label         = '';

            if( options.min && options.limit && wordCount == 0 ) {

                label  = this.prepareLabel( [ options.minDefaultLabelSingular, options.minDefaultLabel ], options.limit, options.min, wordCount );
                label += ', ' + this.prepareLabel( [ options.defaultLabelSingular, options.defaultLabel ], options.limit, options.min, wordCount );

            } else if( options.min && ( options.limit ? wordCount < options.min : true ) ) {

                if( wordCount == 0 ) {
                    label = [ options.minDefaultLabelSingular, options.minDefaultLabel ];
                } else if( wordCount < options.min ) {
                    label = [ options.minCounterLabelSingular, options.minCounterLabel ];
                } else {
                    label = options.minReachedLabel;
                }

            } else {

                if( wordCount == 0 ) {
                    label = [ options.defaultLabelSingular, options.defaultLabel ];
                } else if( wordCount >= options.limit ) {

                    if( options.truncate ) {

                        wordCount = options.limit;
                        label     = options.limitReachedLabel;

                        $( this ).val( this.truncate( text ) );

                    } else {
                        label = wordCount > options.limit ? options.limitExceededLabel :  options.limitReachedLabel;
                    }

                } else {
                    label = [ options.counterLabelSingular, options.counterLabel ];
                }

            }

            counterLabel.html( this.prepareLabel( label, options.limit, options.min, wordCount ) );

            if( previousCount != wordCount ) {
                $( document ).trigger( 'textareaCounterUpdate', [ wordCount, obj, origWordCount ] );
            }
            
            previousCount = wordCount;

        };

        this.prepareLabel = function( label, max, min, wordCount ) {

            var remaining, count;

            max = parseInt( max );
            min = parseInt( min );
            wordCount = parseInt( wordCount );

            if( min && wordCount < min ) {
                remaining = min - wordCount;
            } else {
                remaining = max - wordCount;
            }

            if( typeof label != 'string' ) {
                if( label[0].match( '{min}' ) ) {
                    count = min;
                } else if( label[0].match( '{max}|{limit}' ) ) {
                    count = max;
                } else if( label[0].match( '{remaining}' ) ) {
                    count = remaining;
                } else {
                    count = wordCount;
                }
                label = count > 1 ? label[1] : label[0];
            }

            return label
                    .replace( '{limit}', max )
                    .replace( '{max}', max )
                    .replace( '{min}', min )
                    .replace( '{remaining}', remaining )
                    .replace( '{count}', wordCount );
        };

        this.truncate = function( text ) {

            var words        = text.match( /\S+/g ),
                whiteSpace   = text.split( /\S+/g ),
                limitedWords = words.slice( 0, options.limit ),
                limitedText  = '';

            for( var i = 0; i < limitedWords.length; i++ ) {
                limitedText += limitedWords[i] + whiteSpace[ i + 1 ];
            }

            return limitedText;
        };
        
        // and the plugin begins
        return this.each(function() {
            var obj, text, wordcount, limited, labelId, counterLabel;
            
            obj = $(this);
            
            labelId = $(this).attr('id') + '-word-count';
            counterLabel = $('#' + labelId);
            
            // functioanlity is triggered via conditional logic, if field is not visible, skip
            if(!obj.is(":visible"))
                return;
            
            // if showCount is enabled and counterLabel does not exist, create it
            if(options.showCount && counterLabel.length <= 0) {
                counterLabel = $('<span style="font-size: 11px; clear: both; margin-top: 3px; display: block;" id="' + labelId + '" class="gp-word-count-label"></span>');
                obj.after(counterLabel);
            }
            
            // update counter label up front for conditional logic
            txtCounterObj.updateWordCount(obj, counterLabel);
            
            obj.keyup(function() {
                txtCounterObj.updateWordCount(obj, counterLabel);
            });
            
        });
    };
    
})(jQuery);
