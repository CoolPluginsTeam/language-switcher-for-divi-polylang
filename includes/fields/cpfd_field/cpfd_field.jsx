// External Dependencies
import React, { Component } from 'react';

// Internal Dependencies
import './style.css';

class cpfd_field extends Component {

  static slug = 'cpfd_field';

  /**
   * Handle input value change.
   *
   * @param {object} event
   */
  _onChange = (event) => {
    this.props._onChange(this.props.name, event.target.value);
  }

  render() {
    return(
      <input
        id={`cpfd-field-${this.props.name}`}
        name={this.props.name}
        value={this.props.value}
        type='text'
        className='cpfd-input'
        onChange={this._onChange}
        placeholder='Your text here ...'
      />
    );
  }
}

export default cpfd_field;
