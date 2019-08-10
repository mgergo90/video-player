import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Helmet } from 'react-helmet';
import { createStructuredSelector } from 'reselect';
import { compose } from 'redux';
import { injectIntl, intlShape } from 'react-intl';
import { Redirect } from 'react-router-dom';

import { withStyles } from '@material-ui/core/styles';

import { makeSelectCurrentUser } from 'containers/App/selectors';
import injectEpic from 'utils/injectEpic';
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

const RegistrationPage = ({ intl, classes, user }) => {
  if (user) {
    return <Redirect to="/" />;
  }

  return (
    <div className={classes.root}>
      <Helmet>
        <title>{intl.formatMessage(messages.pageTitle)}</title>
      </Helmet>
      <RegistrationForm />
    </div>
  );
};

RegistrationPage.defaultProps = {
  user: null,
};

RegistrationPage.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
  user: PropTypes.instanceOf(Object),
};

const mapStateToProps = createStructuredSelector({
  user: makeSelectCurrentUser(),
});

const withConnect = connect(mapStateToProps);

const withEpic = injectEpic(epic, 'registrationPage');

export default compose(
  withEpic,
  withConnect,
  injectIntl,
)(withStyles(styles)(RegistrationPage));
