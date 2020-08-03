import React, { Component } from 'react'

export class StatusInput extends Component {
  constructor(props) {
    super(props);
    this.handleStatusClick = this.handleStatusClick.bind(this);
  }

  handleStatusClick(e) {
    this.props.onChangeStatus(e.target.getAttribute('data-unit'), e.target.getAttribute('data-charge'));
  }

  render() {
  	let statusMessage;
  	let buttonConfig;
  	if (this.props.status == "charging" ) {
  		statusMessage = <h5 className="status-info charging">{this.props.status}</h5>
  		buttonConfig = <input type="button" 
			  		className="btn-large orange" 
			  		value="Stop" 
			  		data-unit={this.props.unitId}
			  		data-charge={this.props.chargeId}
			  		onClick={this.handleStatusClick} />

  	} else {
  		statusMessage = <h5 className="status-info available">{this.props.status}</h5>
  		buttonConfig = <input type="button" 
		  		className="btn-large green" 
		  		value="Start"
		  		data-unit={this.props.unitId}
			  	data-charge={this.props.chargeId}
			  	onClick={this.handleStatusClick} />
  	}

    return (
		<div className="center-align">
			{statusMessage}
			{buttonConfig}
		</div>
    );
  }
}

export default StatusInput;