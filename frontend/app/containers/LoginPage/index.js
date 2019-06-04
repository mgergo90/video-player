import React from 'react';
import PropTypes from 'prop-types';
import { Helmet } from 'react-helmet';
import { injectIntl, intlShape } from 'react-intl';
import { compose } from 'redux';

import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';

import messages from './messages';
import LoginForm from './loginForm';

const styles = {
  loginCard: {
    display: 'flex',
    position: 'fixed',
    top: 0,
    left: 0,
    width: '100%',
    height: '100%',
    alignItems: 'center',
    justifyContent: 'center',
  },
};

const LoginPage = ({ classes, intl }) => (
  <Paper className={classes.loginCard}>
    <Helmet>
      <title>{intl.formatMessage(messages.header)}</title>
    </Helmet>
    <LoginForm />
  </Paper>
);

LoginPage.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
};

export default compose(injectIntl)(withStyles(styles)(LoginPage));
