import React from 'react';
import ReactDOM  from 'react-dom/client';
import './components/Assets/style/normalize.css';
import './components/Assets/style/style.css';
import './all.min.css'
import {BrowserRouter as Router} from 'react-router-dom'
import App from './App';
const root=ReactDOM.createRoot(document.getElementById("root"))
root.render(
    <Router>
        <App />
    </Router>
    
);