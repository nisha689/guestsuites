/**
 * number spinner 
 */
 jQuery(function($){
	$.datepicker.regional['fr'] = {
		monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
		'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
	    monthNamesShort: ['janv','févr','mars','avr','mai','juin',
    'juil','août','sept','oct','nov','déc'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
});
Vue.component('spinner', {
  template: `
    <span class="custom-spinner">
      <input data-spinner v-model="value" data-text="FUT / 5"> 
    </span>
  `,
  props:['value'],
  data() {
    return {}
  },
  methods: {},
  mounted:function(){
    var vm = this;
    
    var spinner = $(vm.$el).find('input[data-spinner]').spinner({ 
      min: 0,
	  max:5,
      spin: function( event, ui ) {
        var $this = $(this);
        
		setTimeout(function(){
		//$(document.activeElement).filter(':input:focus').blur();

          $this.val($this.attr('aria-valuenow'));
          $this.closest('.ui-spinner').find('.spinner-text').html(function(){
            return ($this.attr('aria-valuenow') +' '+ $this.attr('data-text'));
          });
          vm.$emit('change',$this);
        },0);
      }
    }).attr('readonly', 'readonly');
    spinner.closest('.ui-spinner').prepend(function(){
      var _spinner = $(this).find('input[data-spinner]');
  //    document.activeElement.blur();
	  return '<span class="spinner-text">'+_spinner.attr('aria-valuenow') +' '+ _spinner.attr('data-text')+'</span>';
    });
  }
});

/**
 * datepicker 
 */


moment.locale('fr', {
  months : 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
  monthsShort : 'janv_févr_mars_avr_mai_juin_juil_août_sept_oct_nov_déc'.split('_'),
  monthsParseExact : true,
  weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
  weekdaysShort : 'dim_lun_mar_mer_jeu_ven_sam'.split('_'),
  weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
  weekdaysParseExact : true,
  longDateFormat : { LT : 'HH:mm', LTS : 'HH:mm:ss', L : 'DD/MM/YYYY', LL : 'D MMMM YYYY', LLL : 'D MMMM YYYY HH:mm', LLLL : 'dddd D MMMM YYYY HH:mm' },
  calendar : { sameDay : '[Aujourd’hui à] LT', nextDay : '[Demain à] LT', nextWeek : 'dddd [à] LT', lastDay : '[Hier à] LT', lastWeek : 'dddd [dernier à] LT', sameElse : 'L' },
  relativeTime : { future : 'dans %s', past : 'il y a %s', s : 'quelques secondes', m : 'une minute', mm : '%d minutes', h : 'une heure', hh : '%d heures', d : 'un jour', dd : '%d jours', M : 'un mois', MM : '%d mois', y : 'un an', yy : '%d ans' },
  dayOfMonthOrdinalParse : /\d{1,2}(er|e)/,
  ordinal : function (number) { return number + (number === 1 ? 'er' : 'e'); },
  meridiemParse : /PD|MD/,
  isPM : function (input) { return input.charAt(0) === 'M'; },
  meridiem : function (hours, minutes, isLower) { return hours < 12 ? 'PD' : 'MD'; },
  week : { dow : 1, doy : 4 }
});

Vue.component('datePicker', {
  template:`
    <div class="modal fade modal-date-picker" :id="id" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <span class="year">{{year}}</span>
            <span class="date">{{weekday}}, {{month}} {{day}}</span>
          </div>
          <div class="modal-body">
            <div :id="id+'_date_picker'"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="cancelDateSelect()">Annuler</button>
				<button type="button" class="btn btn-primary" @click="acceptDateSelect()">D&rsquo;accord</button>
          </div>
        </div>
      </div>
    </div>
  `,
  props:['id','options','date'],
  data() {
    return {
      oldDate:'',
      year :'2020',
      weekday  : 'Sun',
      month : 'Oct',
      day :'20'
    }
  },
  methods: {
    cancelDateSelect:function(){
      this.$emit('cancel',this.oldDate);
      this.toggleDatePicker(false);
    },
    acceptDateSelect:function(){
      this.$emit('change',{
        oldDate:this.oldDate,
        date:this.date
      });
      this.toggleDatePicker(false);
    },
    toggleDatePicker:function(show){
      var toggle = show ? 'show':'hide';
      $('#'+this.id).modal(toggle);
    },
    prepareDisplayDate:function(){
      var vm = this;
      var dt, year, month, day, weekday;
      moment.locale('fr');

      //console.log(moment);
      
      if(vm.date == ''){
        dt = moment(new Date());
        
        year = dt.format('YYYY');
        month = dt.format('MMM');
        day = dt.format('DD');
        weekday = dt.format('ddd');
        monthNumber = dt.format('MM');

        vm.date = (day+'/'+monthNumber+'/'+year); 
      }else{
        dt = moment(vm.date,'DD/MM/YYYY');
        year = dt.format('YYYY');
        month = dt.format('MMM');
        day = dt.format('DD');
        weekday = dt.format('ddd');
      }
      vm.year  = year;
      vm.weekday = weekday;
      vm.month = month;
      vm.day  = day;
    }
  },
  mounted:function(){
    var vm = this;
    vm.prepareDisplayDate();
    
    vm.oldDate = vm.date;
    var datepicker = $('#'+vm.id+'_date_picker').datepicker({
      dateFormat: "dd/mm/yy",
      minDate: new Date(),
      defaultDate:vm.date,
      changeMonth: true,
      changeYear: true,
      yearRange: "+0:+100",
      onSelect:function(date,params){
        vm.date = date;
        vm.prepareDisplayDate();
      }
    });
    
    $('#'+this.id).on('shown.bs.modal', function (e) {
      console.log(vm.date);
      
      datepicker.datepicker( "setDate",vm.date);
      vm.prepareDisplayDate();
    })
  }
});



