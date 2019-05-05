/* eslint-disable react/forbid-foreign-prop-types */
/**
 *
 * App
 *
 * This component is the skeleton around the actual pages, and should only
 * contain code that should be seen on all pages. (e.g. navigation bar)
 */

import React, { Suspense, lazy, Fragment } from 'react';
import PropTypes from 'prop-types';
import { Helmet } from 'react-helmet';
import { withStyles } from '@material-ui/core/styles';
import { Switch, Route } from 'react-router-dom';

import Loader from 'components/Loader';

// https://github.com/ReactTraining/react-router/issues/6420
Route.propTypes.component = PropTypes.oneOfType([
  Route.propTypes.component,
  PropTypes.object,
]);

const FilterPage = lazy(() => import('containers/FilterPage'));
const NotFoundPage = lazy(() => import('containers/NotFoundPage'));

const styles = () => ({
  root: {
    display: 'flex',
  },
});

const App = ({ classes }) => (
  <Fragment>
    <Helmet titleTemplate="%s - Video Finder" defaultTitle="Video Finder" />
    <Suspense fallback={<Loader />}>
      <div className={classes.root}>
        <Switch>
          <Route exact path="/" component={FilterPage} />
          <Route path="" component={NotFoundPage} />
        </Switch>
      </div>
    </Suspense>
  </Fragment>
);

App.propTypes = {
  classes: PropTypes.instanceOf(Object),
};

export default withStyles(styles)(App);
