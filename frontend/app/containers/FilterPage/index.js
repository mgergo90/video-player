/**
 *
 * FilterPage
 *
 */

import React from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { Helmet } from 'react-helmet';
import { FormattedMessage } from 'react-intl';
import { compose } from 'redux';

import VideoFilter from 'containers/VideoFilter';
import messages from './messages';

const FilterPage = () => {
  const name = 'FilterPage';
  return (
    <React.Fragment>
      <Helmet>
        <title>{name}</title>
        <meta name="description" content={`Description of ${name}`} />
      </Helmet>
      <VideoFilter />
    </React.Fragment>
  );
};

FilterPage.propTypes = {
  dispatch: PropTypes.func.isRequired,
};

const mapDispatchToProps = dispatch => ({
  dispatch,
});

const withConnect = connect(
  null,
  mapDispatchToProps,
);

export default compose(withConnect)(FilterPage);
