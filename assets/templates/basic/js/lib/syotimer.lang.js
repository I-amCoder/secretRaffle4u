    $.syotimerLang = {
        rus: {
            second: ['ÑÐµÐºÑƒÐ½Ð´Ð°', 'ÑÐµÐºÑƒÐ½Ð´Ñ‹', 'ÑÐµÐºÑƒÐ½Ð´'],
            minute: ['Ð¼Ð¸Ð½ÑƒÑ‚Ð°', 'Ð¼Ð¸Ð½ÑƒÑ‚Ñ‹', 'Ð¼Ð¸Ð½ÑƒÑ‚'],
            hour: ['Ñ‡Ð°Ñ', 'Ñ‡Ð°ÑÐ°', 'Ñ‡Ð°ÑÐ¾Ð²'],
            day: ['Ð´ÐµÐ½ÑŒ', 'Ð´Ð½Ñ', 'Ð´Ð½ÐµÐ¹'],
            handler: 'rusNumeral'
        },
        eng: {
            second: ['second', 'seconds'],
            minute: ['minute', 'minutes'],
            hour: ['hour', 'hours'],
            day: ['day', 'days']
        },
        por: {
            second: ['segundo', 'segundos'],
            minute: ['minuto', 'minutos'],
            hour: ['hora', 'horas'],
            day: ['dia', 'dias']
        },
        spa: {
            second: ['segundo', 'segundos'],
            minute: ['minuto', 'minutos'],
            hour: ['hora', 'horas'],
            day: ['dÃ­a', 'dÃ­as']
        },
        heb: {
            second: ['×©× ×™×”', '×©× ×™×•×ª'],
            minute: ['×“×§×”', '×“×§×•×ª'],
            hour: ['×©×¢×”', '×©×¢×•×ª'],
            day: ['×™×•×', '×™×ž×™×']
        },

        /**
         * Universal function for get correct inducement of nouns after a numeral (`number`)
         * @param number
         * @returns {number}
         */
        universal: function(number) {
            return ( number === 1 ) ? 0 : 1;
        },

        /**
         * Get correct inducement of nouns after a numeral for Russian language (rus)
         * @param number
         * @returns {number}
         */
        rusNumeral: function(number) {
            var cases = [2, 0, 1, 1, 1, 2],
                index;
            if ( number % 100 > 4 && number % 100 < 20 ) {
                index = 2;
            } else {
                index = cases[(number % 10 < 5) ? number % 10 : 5];
            }
            return index;
        },

        /**
         * Getting the correct declension of words after numerals
         * @param number
         * @param lang
         * @param unit
         * @returns {string}
         */
        getNumeral: function(number, lang, unit) {
            var handlerName = $.syotimerLang[lang].handler || 'universal',
                index = this[handlerName](number);
            return $.syotimerLang[lang][unit][index];
        }
    };