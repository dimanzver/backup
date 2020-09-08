import {
  toDayMonth, formatToHumanDate, toMonthLabel, toTime,
} from './time';

Vue.filter('toDayMonth', toDayMonth);
Vue.filter('formatToHumanDate', formatToHumanDate);
Vue.filter('toMonthLabel', toMonthLabel);
Vue.filter('toTime', toTime);