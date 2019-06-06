import React from 'react';
import PropTypes from 'prop-types';
import { Helmet } from 'react-helmet';
import { injectIntl, intlShape } from 'react-intl';
import { compose } from 'redux';

import { withStyles } from '@material-ui/core/styles';

import messages from './messages';
import LoginForm from './loginForm';

const styles = {
  loginCard: {
    display: 'flex',
    width: '100%',
    height: '100%',
    alignItems: 'center',
    justifyContent: 'center',
    margin: '60px auto',
  },
};

const LoginPage = ({ classes, intl }) => (
  <div className={classes.loginCard}>
    <Helmet>
      <title>{intl.formatMessage(messages.header)}</title>
    </Helmet>
    <LoginForm />
  </div>
);

LoginPage.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
};

export default compose(injectIntl)(withStyles(styles)(LoginPage));
