import React, { useEffect } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { compose } from 'redux';
import { createStructuredSelector } from 'reselect';
import Link from 'react-router-dom/Link';

import { withStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import IconButton from '@material-ui/core/IconButton';
import Tooltip from '@material-ui/core/Tooltip';
import Icon from '@material-ui/core/Icon';
import { selectLists } from './selectors';
import { fetchPlayLists } from './actions';

const styles = theme => ({
  root: {
    width: '100%',
    marginTop: theme.spacing,
    overflowX: 'auto',
  },
  table: {
    minWidth: 650,
  },
  name: {
    width: '80%',
  },
});

const PlayListTable = props => {
  const { classes } = props;
  useEffect(() => {
    props.fetchPlayLists();
  }, []);

  return (
    <Paper className={classes.root}>
      <Toolbar>
        <Typography variant="h6" id="tableTitle">
          Play Lists
        </Typography>
        <div className={classes.spacer} />
        <div className={classes.actions}>
          <Link to="/play-lists/add">
            <Tooltip title="Add">
              <IconButton aria-label="add">
                <Icon color="primary">add_circle</Icon>
              </IconButton>
            </Tooltip>
          </Link>
        </div>
      </Toolbar>
      <Table className={classes.table}>
        <TableHead>
          <TableRow>
            <TableCell className={classes.name}>Name</TableCell>
            <TableCell>ACtion</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {props.lists.map(row => (
            <TableRow key={row.id}>
              <TableCell>
                <Link to={`/play-lists/${row.id}`}>{row.attributes.name}</Link>
              </TableCell>
              <TableCell>
                <Link to={`/play-lists/edit/${row.id}`}>
                  <Tooltip title="Edit">
                    <IconButton aria-label="edit">
                      <Icon color="primary">edit</Icon>
                    </IconButton>
                  </Tooltip>
                </Link>
              </TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </Paper>
  );
};

PlayListTable.propTypes = {
  fetchPlayLists: PropTypes.func.isRequired,
  lists: PropTypes.instanceOf(Array).isRequired,
  classes: PropTypes.instanceOf(Object).isRequired,
};

const mapStateToProps = createStructuredSelector({
  lists: selectLists,
});

const mapDispatchToProps = dispatch => ({
  fetchPlayLists: compose(
    dispatch,
    fetchPlayLists,
  ),
});

export default connect(
  mapStateToProps,
  mapDispatchToProps,
)(withStyles(styles)(PlayListTable));
