/**
 *
 * RegistrationPage
 *
 */

import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Helmet } from 'react-helmet';
import { createStructuredSelector } from 'reselect';
import { compose } from 'redux';
import { injectIntl, intlShape } from 'react-intl';

import { withStyles } from '@material-ui/core/styles';
import Paper from '@material-ui/core/Paper';

import injectEpic from 'utils/injectEpic';
import injectReducer from 'utils/injectReducer';
import makeSelectRegistrationPage from './selectors';
import reducer from './reducer';
import epic from './epic';
import messages from './messages';
import RegistrationForm from './registrationForm';

const styles = {
  root: {
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

const RegistrationPage = ({ intl, classes }) => (
  <Paper className={classes.root}>
    <Helmet>
      <title>{intl.formatMessage(messages.pageTitle)}</title>
    </Helmet>
    <RegistrationForm />
  </Paper>
);

RegistrationPage.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
};

const mapStateToProps = createStructuredSelector({
  registrationPage: makeSelectRegistrationPage(),
});

const mapDispatchToProps = dispatch => ({
  dispatch,
});

const withConnect = connect(
  mapStateToProps,
  mapDispatchToProps,
);

const withReducer = injectReducer({ key: 'registrationPage', reducer });
const withEpic = injectEpic(epic);

export default compose(
  withReducer,
  withEpic,
  withConnect,
  injectIntl,
)(withStyles(styles)(RegistrationPage));
