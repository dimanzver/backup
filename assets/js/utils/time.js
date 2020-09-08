/**
 *
 * @param {Date|string} date
 * @return {string}
 */
export function formatToHumanDate(date) {
  date = resolveDate(date);
  return `${toDayMonth(date)} ${date.getFullYear()}`;
}

/**
 * If need, convert date string to Date
 *
 * @param {Date|string} date
 * @return {Date|*}
 */
export function resolveDate(date) {
  if (typeof date === 'string') {
    // FUCK SAFARI
    // Фиксим баг в Safari
    date = date.replace(/(\d\d\d\d-\d\d-\d\d)\s/, '$1T');

    // Проверяем, указано ли время - опять же баги
    if(!date.match(/\d\d:\d\d:\d\d/))
      date += 'T00:00:00';

    // Проверяем, указан ли часовой пояс - опять же, Safari по-другому парсит дату, если не указан часовой пояс
    if(!date.match(/[+-]\d\d:\d\d$/))
      date += '+03:00';

    return new Date(Date.parse(date));
  }

  if (typeof date === 'number') {
    return new Date(date * 1000);
  }

  return new Date(date.getTime());
}

/**
 * Format date to nice format
 * (example: 18 мая)
 *
 * @param {Date|string} date
 * @return {string}
 */
export function toDayMonth(date) {
  date = resolveDate(date);
  return `${date.getDate()} ${toMonthLabel(date.getMonth())}`;
}

/**
 * @param {Number} month
 * @param {boolean} inf
 * @return {string}
 */
export function toMonthLabel(month, inf = false) {
  const months = !inf ? ['января', 'февраля', 'марта', 'апреля', 'мая',
      'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'] :
    ['январь', 'февраль', 'март', 'апрель', 'май',
      'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'];
  return months[month];
}

/**
 *
 * @param {Date|String} date
 * @returns {string}
 */
export function toTime(date) {
  date = resolveDate(date);
  const hours = date.getHours();
  const minutes = date.getMinutes();
  return `${
    hours > 9 ? hours : '0' + hours
  }:${
    minutes > 9 ? minutes : '0' + minutes
  }`;
}