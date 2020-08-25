import store from './../store';

export default class ErrorProcessing {
  /**
   * Show all API errors in 1 format
   *
   * @param {string} error
   */
  static showError(error) {
    store.dispatch('addDanger', error);
  }

  /**
   * Get validation error message string from XMLHttpRequest
   * @param {Response} response
   * @return {string}
   */
  static async getValidationError(response) {
    let errors = await response.json();
    if (typeof errors === 'string') {
      errors = [errors];
    } else if (errors instanceof Array) {
      errors = errors.map(error => {
        if (error instanceof Object) {
          return error.message;
        }
        return error;
      });
    }

    return errors.join('\n');
  }

  /**
   * Get error message string from Response
   * @param {Response} response
   * @return {string}
   */
  static async getErrorMessage(response) {
    switch (response.status) {
      case 401:
        return 'Недостаточно прав';

      case 403:
        return 'Недостаточно прав';

      case 500:
        return 'На сервере произошла ошибка';

      case 404:
        return 'Запрашиваемый ресурс не найден';

      case 422:
        return await this.getValidationError(response);

      default:
        return 'Произошла ошибка';
    }
  }
}
