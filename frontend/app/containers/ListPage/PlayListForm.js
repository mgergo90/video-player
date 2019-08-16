import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { injectIntl, intlShape } from 'react-intl';
import { compose } from 'redux';
import { Formik, Field, Form } from 'formik';
import { Link } from 'react-router-dom';
import * as Yup from 'yup';

import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogTitle from '@material-ui/core/DialogTitle';
import { withStyles } from '@material-ui/core/styles';
import FormHelperText from '@material-ui/core/FormHelperText';

import InputField from 'components/InputField';
import globalMessages from 'containers/App/messages';
import { savePlayList } from './actions';

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

const playListSchema = intl =>
  Yup.object().shape({
    attributes: Yup.object().shape({
      name: Yup.string().required(intl.formatMessage(globalMessages.required)),
    }),
  });

const PlayListForm = ({ playList, classes, intl, save, title }) => (
  <Dialog
    open
    aria-labelledby="responsive-dialog-title"
    PaperProps={{ className: classes.card }}
  >
    <DialogTitle id="responsive-dialog-title">{title}</DialogTitle>
    <Formik
      className={classes.card}
      initialValues={playList}
      validationSchema={playListSchema(intl)}
      onSubmit={save}
      render={({ isSubmitting, status }) => (
        <Form>
          <DialogContent>
            <Field
              type="text"
              name="attributes.name"
              component={InputField}
              label={intl.formatMessage(globalMessages.name)}
            />
            <FormHelperText error>
              {status && status.backendError}
            </FormHelperText>
          </DialogContent>
          <DialogActions>
            <Button
              variant="outlined"
              size="medium"
              color="primary"
              component={Link}
              to="/play-lists"
            >
              {intl.formatMessage(globalMessages.cancel)}
            </Button>
            <Button
              type="submit"
              disabled={isSubmitting}
              variant="contained"
              color="primary"
            >
              {intl.formatMessage(globalMessages.save)}
            </Button>
          </DialogActions>
        </Form>
      )}
    />
  </Dialog>
);

PlayListForm.propTypes = {
  intl: intlShape.isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
  playList: PropTypes.instanceOf(Object).isRequired,
  save: PropTypes.func.isRequired,
  title: PropTypes.string.isRequired,
};

const mapDispatchToProps = dispatch => ({
  save: compose(
    dispatch,
    savePlayList,
  ),
});

const withConnect = connect(
  null,
  mapDispatchToProps,
);

export default compose(
  withConnect,
  injectIntl,
)(withStyles(styles)(PlayListForm));
