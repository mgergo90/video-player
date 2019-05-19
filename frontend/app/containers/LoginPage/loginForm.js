/**
 *
 * LoginPage
 *
 */

import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { injectIntl, intlShape } from 'react-intl';
import { createStructuredSelector } from 'reselect';
import { compose } from 'redux';
import { Formik, Field, Form } from 'formik';
import { Link } from 'react-router-dom';
import * as Yup from 'yup';

import { withStyles } from '@material-ui/core/styles';
import Card from '@material-ui/core/Card';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import Button from '@material-ui/core/Button';
import FormHelperText from '@material-ui/core/FormHelperText';

import InputField from 'components/InputField';
import makeSelectLoginPage from './selectors';
import messages from './messages';
import { loginUser } from './actions';

const styles = {
  card: {
    maxWidth: '400px',
    width: '100%',
  },
  bullet: {
    display: 'inline-block',
    margin: '0 2px',
    transform: 'scale(0.8)',
  },
  title: {
    fontSize: 14,
  },
  pos: {
    marginBottom: 12,
  },
};

const loginSchema = intl =>
  Yup.object().shape({
    email: Yup.string()
      .email(intl.formatMessage(messages.emailInvalid))
      .required(intl.formatMessage(messages.required)),
    password: Yup.string().required(intl.formatMessage(messages.required)),
  });

const LoginForm = ({ login, classes, intl }) => (
  <Card className={classes.card}>
    <Formik
      initialValues={{
        password: '',
        email: '',
      }}
      onSubmit={login}
      validationSchema={loginSchema(intl)}
      render={({ isSubmitting, status }) => (
        <Form>
          <CardContent>
            <Field
              type="email"
              name="email"
              component={InputField}
              label={intl.formatMessage(messages.email)}
            />
            <Field
              type="password"
              name="password"
              component={InputField}
              label={intl.formatMessage(messages.password)}
            />
            <FormHelperText error>
              {status && status.backendError}
            </FormHelperText>
          </CardContent>
          <CardActions>
            <Button
              variant="outlined"
              size="medium"
              color="primary"
              component={Link}
              to="/registration"
            >
              {intl.formatMessage(messages.newAccountButton)}
            </Button>
            <Button
              type="submit"
              disabled={isSubmitting}
              variant="contained"
              color="primary"
            >
              {intl.formatMessage(messages.loginButton)}
            </Button>
          </CardActions>
        </Form>
      )}
    />
  </Card>
);

LoginForm.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
  login: PropTypes.func.isRequired,
};

const mapStateToProps = createStructuredSelector({
  loginPage: makeSelectLoginPage(),
});

const mapDispatchToProps = dispatch => ({
  login: compose(
    dispatch,
    loginUser,
  ),
});

const withConnect = connect(
  mapStateToProps,
  mapDispatchToProps,
);

export default compose(
  withConnect,
  injectIntl,
)(withStyles(styles)(LoginForm));
