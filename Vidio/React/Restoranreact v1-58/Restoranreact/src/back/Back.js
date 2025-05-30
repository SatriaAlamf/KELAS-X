import React, { useEffect, useState } from 'react';
import { Navigate } from 'react-router-dom';
import Nav from './Nav';
import Side from './Side';
import Main from './Main';
import Footer from './Footer';

const Back = () => {
  const [isAuthenticated, setIsAuthenticated] = useState(null); // null = loading

  useEffect(() => {
    const checkAuth = () => {
      const token = localStorage.getItem('token');
      if (!token || token.trim() === '' || token === 'null' || token === 'undefined') {
        setIsAuthenticated(false);
        return;
      }
      setIsAuthenticated(true);
    };
    checkAuth();
  }, []);

  if (isAuthenticated === null) {
    return (
      <div className="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div className="spinner-border text-primary" role="status">
          <span className="visually-hidden">Loading...</span>
        </div>
        <span className="ms-3">Loading...</span>
      </div>
    );
  }

  if (!isAuthenticated) {
    return <Navigate to="/login" replace />;
  }

  return (
    <div className="back bg-light min-vh-100 d-flex flex-column">
      <Nav />
      <div className="container flex-grow-1 my-4">
        <div className="row">
          <aside className="col-md-3 mb-3 mb-md-0">
            <div className="card h-100 shadow-sm">
              <div className="card-body p-3">
                <Side />
              </div>
            </div>
          </aside>
          <main className="col-md-9">
            <div className="card h-100 shadow-sm">
              <div className="card-body p-4">
                <Main />
              </div>
            </div>
          </main>
        </div>
      </div>
      <Footer />
    </div>
  );
};

export default Back;