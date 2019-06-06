import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Helmet } from 'react-helmet';
import { createStructuredSelector } from 'reselect';
import { compose } from 'redux';
import { injectIntl, intlShape } from 'react-intl';

import { withStyles } from '@material-ui/core/styles';

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
    width: '100%',
    height: '100%',
    alignItems: 'center',
    justifyContent: 'center',
    margin: '60px auto',
  },
};

const RegistrationPage = ({ intl, classes }) => (
  <div className={classes.root}>
    <Helmet>
      <title>{intl.formatMessage(messages.pageTitle)}</title>
    </Helmet>
    <RegistrationForm />
  </div>
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
