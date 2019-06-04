/*
 * RegistrationPage Messages
 *
 * This contains all the text for the RegistrationPage container.
 */

import { defineMessages } from 'react-intl';

export const scope = 'app.containers.RegistrationPage';

export default defineMessages({
  pageTitle: {
    id: `${scope}.pageTitle`,
    defaultMessage: 'Registration',
  },
  cancelButton: {
    id: `${scope}.cancelButton`,
    defaultMessage: 'Cancel',
  },
  emailInvalid: {
    id: `${scope}.emailInvalid`,
    defaultMessage: 'Invalid e-mail address',
  },
  passwordNotMatch: {
    id: `${scope}.passwordNotMatch`,
    defaultMessage: 'Passwords must match',
  },
});
