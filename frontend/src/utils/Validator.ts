export const Validator = {
  required: (fieldName: string) => (value: string) => {
    if (!value) {
      return `${fieldName} is required`;
    }
    return true;
  },
  dateRange: (minDate: string, maxDate: string) => (value: string) => {
    if (!value) {
      return 'Date is required';
    }
    if (value < minDate) {
      return `Date cannot be earlier than ${minDate}`;
    }
    if (value > maxDate) {
      return `Date cannot be later than ${maxDate}`;
    }
    return true;
  },
  dateOrder: (dateFrom: string, dateTo: string) => {
    if (dateFrom && dateTo && dateFrom > dateTo) {
      return 'Date From must be before Date To';
    }
    return true;
  },
  email: (value: string) => {
    if (!value) {
      return 'Email address is required';
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
      return 'Email address must be valid';
    }
    return true;
  },
  phoneNumber: (value: string) => {
    if (!value) {
      return 'Phone number is required';
    }
    if (!/^\+\d{2} \d{3} \d{3} \d{3}$/.test(value)) {
      return 'Phone number must match the format +## ### ### ###';
    }
    return true;
  },
}