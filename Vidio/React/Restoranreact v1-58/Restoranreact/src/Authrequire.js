import React from 'react';
import { Navigate } from 'react-router-dom';
const Authrequire = ({ children }) => {
  const token = localStorage.getItem('token');
  console.log('requireAuth: token =', token);
  if (!token) {
    return <Navigate to="/login" replace />;
  }
  return children;
};
export default Authrequire;
