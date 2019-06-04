/**
 *
 * LoginPage
 *
 */

import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { injectIntl, intlShape } from 'react-intl';
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
import globalMessages from 'containers/App/messages';
import messages from './messages';
import { postRegistrationForm } from './actions';

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

const registrationSchema = intl =>
  Yup.object().shape({
    email: Yup.string()
      .email(intl.formatMessage(messages.emailInvalid))
      .required(intl.formatMessage(globalMessages.required)),
    name: Yup.string()
      .required(intl.formatMessage(globalMessages.required))
      .max(50, intl.formatMessage(globalMessages.maxLength, { number: 50 })),
    password: Yup.string()
      .required(intl.formatMessage(globalMessages.required))
      .min(6, intl.formatMessage(globalMessages.minLength, { number: 6 }))
      .max(50, intl.formatMessage(globalMessages.maxLength, { number: 50 })),
    password_confirmation: Yup.string()
      .oneOf(
        [Yup.ref('password'), null],
        intl.formatMessage(messages.passwordNotMatch),
      )
      .required(intl.formatMessage(globalMessages.required)),
  });

const RegistrationForm = ({ registration, classes, intl }) => (
  <Card className={classes.card}>
    <Formik
      initialValues={{
        name: '',
        password: '',
        password_confirmation: '',
        email: '',
      }}
      onSubmit={registration}
      validationSchema={registrationSchema(intl)}
      render={({ isSubmitting, status }) => (
        <Form>
          <CardContent>
            <Field
              type="input"
              name="email"
              component={InputField}
              label={intl.formatMessage(globalMessages.email)}
            />
            <Field
              type="input"
              name="name"
              component={InputField}
              label={intl.formatMessage(globalMessages.name)}
            />
            <Field
              type="password"
              name="password"
              component={InputField}
              label={intl.formatMessage(globalMessages.password)}
            />
            <Field
              type="password"
              name="password_confirmation"
              component={InputField}
              label={intl.formatMessage(globalMessages.confirmPassword)}
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
              to="/"
            >
              Cancel
            </Button>
            <Button
              type="submit"
              disabled={isSubmitting}
              variant="contained"
              color="primary"
            >
              Submit
            </Button>
          </CardActions>
        </Form>
      )}
    />
  </Card>
);

RegistrationForm.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
  registration: PropTypes.func.isRequired,
};

const mapDispatchToProps = dispatch => ({
  registration: compose(
    dispatch,
    postRegistrationForm,
  ),
});

const withConnect = connect(
  null,
  mapDispatchToProps,
);

export default compose(
  withConnect,
  injectIntl,
)(withStyles(styles)(RegistrationForm));
