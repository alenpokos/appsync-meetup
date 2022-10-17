import { h, render, Component } from 'preact';
import axios from 'axios';
import { Amplify, API, graphqlOperation } from 'aws-amplify';
import {publish, subscribe} from './aws-exports'
import {config} from '../config'

export default class App extends Component {
	constructor() {
		super();
		const playerName = window.prompt("What is your player name?", `Anon${Math.floor(Math.random()*1000)}`)
		let state = { grid: [], myposition: null, playerName:playerName };
		for(let i = 0; i < 36; i++){
			state.grid[i] = [];
		}
		this.state = state;

		Amplify.configure(config)

		const subscription = subscribe('game',(payload) => {
			let data = JSON.parse(JSON.parse(payload.data));
			this.playerAction(data.player, data.position);
		});

		this.playerPositions = {};
	};
	move = e => {
		const position = parseInt(e.target.id);
		if(this.state.myposition === position) {
			return;
		}
		this.setState({ myposition: position });

		let hitlog = this.state.grid[position].join(',');
		publish('game', `"{\\"position\\":${position}, \\"player\\":\\"${this.state.playerName}\\", \\"hits\\":\\"${hitlog}\\"}"`)
		.then(res => {
			console.log(res.data);
		})
		.catch(err => {
			console.log(err.message);
		});
	};
	playerAction = (player, position) => {
		if(this.state.playerName === player) {
			return;
		}
		this.playerPositions[player]=position;
		let grid = [];
		for(let i = 0; i < 36; i++){grid[i]=[];}
		for (let [player, position] of Object.entries(this.playerPositions)) {
			grid[position].push(player);
		}
		this.setState({grid:grid});
	};
	render({ }, { grid, myposition }) {
		return (
			<div id="app">
				<ol>
				{ grid.map( (block, blockId) => (
					<li id={blockId} onClick={this.move}>
						{blockId == myposition &&
							<span class="player me">ME</span>
						}
						{block.map(player=>(
							<span class="player">{player}</span>
						))}
					</li>
				)) }
			</ol>
			</div>
		);
	}
}
