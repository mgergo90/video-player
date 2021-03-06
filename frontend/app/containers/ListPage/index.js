/**
 *
 * ListPage
 *
 */

import React, { lazy } from 'react';
import { compose } from 'redux';
import { Switch, Route } from 'react-router-dom';

import injectEpic from 'utils/injectEpic';
import injectReducer from 'utils/injectReducer';
import reducer from './reducer';
import epic from './epic';
import PlayListAddForm from './PlayListAddForm';
import PlayListTable from './PlayListTable';
import PlayListEditForm from './PlayListEditForm';

const VideosPage = lazy(() => import('./PlayListPage'));

const ListPage = () => (
  <Switch>
    <Route exact path="/" component={PlayListTable} />
    <Route exact path="/play-lists" component={PlayListTable} />
    <Route exact path="/play-lists/add" component={PlayListAddForm} />
    <Route exact path="/play-lists/edit/:id" component={PlayListEditForm} />
    <Route exact path="/play-lists/:id" component={VideosPage} />
  </Switch>
);

const withReducer = injectReducer({ key: 'listPage', reducer });
const withEpic = injectEpic(epic, 'listPage');

export default compose(
  withReducer,
  withEpic,
)(ListPage);
