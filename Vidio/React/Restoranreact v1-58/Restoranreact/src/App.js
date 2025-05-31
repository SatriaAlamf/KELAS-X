import logo from './logo.svg';
import './App.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

import Back from './back/Back';
import Login from './back/Login';
import RequireAuth from './Authrequire'; // tambahkan ini

function App() {
  return (
    <Router>
      <div className="App">
        <Routes>
          <Route path="/" element={<front />} />
          <Route path="/Login" element={<Login />} />
          <Route 
            path="/admin/*" 
            element={
              <RequireAuth>
                <Back />
              </RequireAuth>
            } 
          />
        </Routes>
      </div>
    </Router>
  );
}

export default App;
