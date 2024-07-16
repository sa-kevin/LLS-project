import { router } from '@inertiajs/react';
import { useState } from 'react';
import { route } from 'ziggy-js';

export default function Wishlist({ wishlists = [] }) {
  const handleRemove = (id) => {
    if (
      confirm('Are you sure you want to remove this book from your wishlist?')
    ) {
      router.delete(route('wishlists.destroy', id), {
        preserveState: true,
        preserveScroll: true,
      });
      setSelectBook(null);
    }
  };

  return (
    <div className="bg-gray-50 shadow-md rounded-lg p-6 h-full flex flex-col">
      <h2 className="text-2xl font-bold mb-8">My Wishlist</h2>
      {wishlists.length === 0 ? (
        <p className="flex-grow flex items-center justify-center text-center text-gray-500">
          Your wishlist is empty,
          <br />
          add Something!
        </p>
      ) : (
        <ul className="overflow-y-auto flex-grow -mr-2 pr-2">
          {wishlists.map((item) => (
            <li
              key={item.id}
              className="mb-3 flex justify-between items-center border-b border-gray-200 pb-3 last:border-b-0 last:mb-0 last:pb-0"
            >
              <span className="mr-2 text-sm">
                <span className="font-semibold">{item.book.title}</span> by{' '}
                {item.book.author}
              </span>
              <button
                onClick={() => handleRemove(item.id)}
                className="bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm flex-shrink-0 transition duration-150 ease-in-out"
              >
                Remove
              </button>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
